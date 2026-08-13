<?php
ob_start();
session_start();

if (isset($_POST['save_page'])) {

$filtered = array_filter($_POST['answer'] ?? [], function($v){
    return $v !== '' && $v !== null;
});


$_SESSION['quiz_answers'] = ($_SESSION['quiz_answers'] ?? []) + $filtered;

    $next_page = (int)$_POST['save_page'];
    $quiz_id = intval($_POST['quiz_id']);

    $subject_id = intval($_POST['subject_id'] ?? 1);

    header("Location: quiz.php?topic_id=" . $quiz_id . "&id=" . $subject_id . "&page=" . $next_page);
    exit;
}
include "../db_config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
function normalizeMath($v) {
    $v = trim((string)$v);

    // saare spaces hatao
    $v = preg_replace('/\s+/u', '', $v);

    // x, X, * sabko × me convert karo
    $v = preg_replace('/[xX*·]/u', '×', $v);

    return mb_strtolower($v);
}

/**
 * Order-insensitive canonical form for worksheet answers where order does NOT matter.
 *
 *   "9,18,36,27"   and  "9,18,27,36"     -> same
 *   "19+17"        and  "17+19"          -> same
 *   "31 & 13"      and  "13 & 31"        -> same
 *   '["90","91"]'  and  "90,91"          -> same   (strips JSON syntax too)
 */
function normalizeUnordered($v) {
    $v = (string)$v;

    // drop JSON syntax so a stored JSON array and a plain comma string match
    $v = str_replace(['[', ']', '"', "'"], '', $v);

    // reuse existing cleanup: strip spaces, lowercase, x/* -> ×
    $v = normalizeMath($v);

    if ($v === '') return '';

    // list level: split on commas
    $tokens = explode(',', $v);

    foreach ($tokens as &$tok) {
        // a token may itself be a commutative join: a+b  or  a&b
        foreach (['+', '&'] as $sep) {
            if (strpos($tok, $sep) !== false) {
                $parts = array_filter(explode($sep, $tok), function ($p) {
                    return $p !== '';
                });
                sort($parts, SORT_NATURAL);
                $tok = implode($sep, $parts);
                break; // one separator per token
            }
        }
    }
    unset($tok);

    // drop empties, then make the list order irrelevant
    $tokens = array_filter($tokens, function ($t) { return $t !== ''; });
    sort($tokens, SORT_NATURAL);

    return implode(',', $tokens);
}

function normalizeExponentExpression($v)
{
    $v = normalizeMath($v);

    $parts = explode('×', $v);

    // empty values remove
    $parts = array_filter($parts);

    // sort terms
    sort($parts, SORT_NATURAL);

    return implode('×', $parts);
}

function isExponentExpression($v)
{
    return preg_match('/[⁰¹²³⁴⁵⁶⁷⁸⁹^]/u', $v)
        || substr_count($v, '×') > 0
        || preg_match('/\d+\^\d+/u', $v);
}

// Check login
if (!isset($_SESSION['student_id'])) {
    header("Location: student_dashboard.php");
    exit();
}
$student_id = $_SESSION['student_id'];

// Validate request
if (!isset($_POST['submit_quiz'])) {
    echo "Invalid Request (submit_quiz missing)<br>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    exit;
}

$quiz_id = intval($_POST['quiz_id'] ?? 0);
//  EMPTY VALUES REMOVE
$filtered_post = array_filter($_POST['answer'] ?? [], function($v){
    return $v !== '' && $v !== null;
});

$_SESSION['quiz_answers'] = ($_SESSION['quiz_answers'] ?? []) + $filtered_post;


$raw_answers = ($_SESSION['quiz_answers'] ?? []) + $filtered_post;
if ($quiz_id == 0) {
    echo "ERROR: quiz_id is missing";
    exit;
}

if (empty($raw_answers)) {
    echo "ERROR: No answers received";
    exit;
}


$sess_key = 'attempt_time_for_topic_' . $quiz_id;
if (!empty($_SESSION[$sess_key])) {
    $created_at = $_SESSION[$sess_key];
} elseif (!empty($_POST['attempt_time'])) {
    $created_at = trim($_POST['attempt_time']);
} else {
    $created_at = date("Y-m-d H:i:s");
}

// ==========================
// PROCESS ANSWERS: Support both single and multi-field (shaded/unshaded)
// ==========================

$answers = [];

foreach ($raw_answers as $qid => $value) {
    $question_id = intval($qid);

if (is_array($value)) {

    $clean = function($arr) use (&$clean) {

        $result = [];

        foreach ($arr as $k => $v) {

            if (is_array($v)) {
                $nested = $clean($v);
                if (!empty($nested)) {
                    $result[$k] = $nested;
                }

            } else {

                $v = trim((string)$v);

                if ($v !== '') {
                    $result[$k] = $v;
                }

            }
        }

        return $result;
    };

    $cleaned = $clean($value);

    $answers[$question_id] = !empty($cleaned) ? json_encode($cleaned) : '';
} else {
        // Single-field answer (all your old templates)
        $answers[$question_id] = trim((string)$value);
    }
}

// Remove empty answers completely
$answers = array_filter($answers, function($ans) {
    return $ans !== '' && $ans !== '[]' && $ans !== '{}';
});

// ==========================
// SAVE ANSWERS
// ==========================
$sql_correct = "SELECT correct_answer, question_type, question_payload
FROM quiz_questions
WHERE id = ?";
$stmt_corr = $conn->prepare($sql_correct);
if (!$stmt_corr) {
    echo "correct_answer prepare error: " . $conn->error;
    exit;
}

$sql_insert = "INSERT INTO student_answers (student_id, quiz_id, question_id, student_answer, is_correct, created_at)
               VALUES (?, ?, ?, ?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);
if (!$stmt_insert) {
    echo "INSERT prepare error: " . $conn->error;
    exit;
}

foreach ($answers as $question_id => $student_answer) {

    // Fetch correct answer
    $stmt_corr->bind_param("i", $question_id);
    $stmt_corr->execute();
    $res_corr = $stmt_corr->get_result();
    $row_corr = $res_corr->fetch_assoc();
    $correct_answer_raw = $row_corr['correct_answer'] ?? '';
    $correct_answer = is_string($correct_answer_raw) ? trim($correct_answer_raw) : '';
    $question_type = $row_corr['question_type'] ?? '';

    $payload = json_decode($row_corr['question_payload'] ?? '{}', true);

    $mode = $payload['mode'] ?? '';

    // prime/composite worksheet modes where item order does NOT matter
    $pc_unordered_modes = [
        'find_multiples_upto', 'sum_two_odd_primes', 'three_odd_primes',
        'prime_composite_less20', 'twin_primes', 'pairs_sum_divisible_5',
        'prime_pairs', 'seven_composite',
    ];
    $pc_is_unordered = ($question_type === 'prime_composite_worksheet'
                        && in_array($mode, $pc_unordered_modes, true));

    // Smart comparison: supports both plain text and JSON correct answers
    $is_correct = 0;

    if ($correct_answer !== '') {
        // Try to decode both as JSON
        $expected_json = json_decode($correct_answer, true);
        $submitted_json = json_decode($student_answer, true);
        //  NORMALIZE student JSON 
        if (is_array($submitted_json) && isset($submitted_json['values'])) {
            $submitted_json = $submitted_json['values'];
        }

 if (is_array($expected_json) && is_array($submitted_json)) {

 // ==========================
//  HISTOGRAM TABLE SUPPORT
// ==========================

if (
    isset($expected_json['freq']) &&
    isset($expected_json['cum']) &&
    isset($submitted_json['freq']) &&
    isset($submitted_json['cum'])
) {

    $is_correct = 1;

    // Frequency check
    foreach ($expected_json['freq'] as $i => $val) {
        $student_val = $submitted_json['freq'][$i] ?? null;

        if (trim((string)$student_val) !== trim((string)$val)) {
            $is_correct = 0;
            break;
        }
    }

    // Cumulative check
    if ($is_correct) {
        foreach ($expected_json['cum'] as $i => $val) {
            $student_val = $submitted_json['cum'][$i] ?? null;

            if (trim((string)$student_val) !== trim((string)$val)) {
                $is_correct = 0;
                break;
            }
        }
    }

    // Max interval check
    if ($is_correct && isset($expected_json['max_interval'])) {
        $student_max = trim((string)($submitted_json['max_interval'] ?? ''));

        if ($student_max !== trim((string)$expected_json['max_interval'])) {
            $is_correct = 0;
        }
    }

}

    if (array_keys($expected_json) !== range(0, count($expected_json) - 1)) {

        $is_correct = 1;

        foreach ($expected_json as $key => $correct_array) {

            if (!isset($submitted_json[$key])) {
                $is_correct = 0;
                break;
            }

            $student_array = $submitted_json[$key] ?? null;

         
    if (is_array($correct_array) && is_array($student_array)) {

    if (count($correct_array) !== count($student_array)) {
        $is_correct = 0;
        break;
    }

    foreach ($correct_array as $i => $correct_val) {

        $student_val = $student_array[$i] ?? null;

        if (is_numeric($correct_val) && is_numeric($student_val)) {
            $tol = 0.001;
            if (abs((float)$correct_val - (float)$student_val) > $tol) {
                $is_correct = 0;
                break 2;
            }
        } else {

           if (
            normalizeMath($student_val)
            !==
            normalizeMath($correct_val)
        )
        {
            $is_correct = 0;
            break 2;
        }
        }
    }

} else {

    //  STRING SAFE COMPARISON
   if (
    strcasecmp(
        trim((string)$correct_array),
        trim((string)$student_array)
    ) !== 0
) {
    $is_correct = 0;
    break;
}

}
        }

    } 

    else {

        // A single value may itself be a product of primes / an exponent
        // expression, e.g. "3 x 3 x 11 x 101" vs "101*11*3*3". For those the
        // ORDER of the factors does NOT matter, so sort the factors before
        // comparing (via normalizeExponentExpression). Plain values still fall
        // back to normalizeMath() exactly as before.
        $normalizeValue = function ($v) {
            $n = normalizeMath($v);
            return isExponentExpression($n)
                ? normalizeExponentExpression($v)
                : $n;
        };

        $correct_values = array_map($normalizeValue, $expected_json);
        $student_values = array_map($normalizeValue, $submitted_json);


        /*
        |--------------------------------------------------------------------------
        | ONLY Odd/Even Worksheet
        |--------------------------------------------------------------------------
        */
        if(
            $question_type === 'odd_even_worksheet'
            &&
            $mode === 'odd_even'
        ){
        
            foreach($correct_values as &$v){
        
                $arr = array_filter(array_map('trim', explode(',', $v)));
        
                sort($arr, SORT_NUMERIC);
        
                $v = implode(',', $arr);
            }
        
            foreach($student_values as &$v){
        
                $arr = array_filter(array_map('trim', explode(',', $v)));
        
                sort($arr, SORT_NUMERIC);
        
                $v = implode(',', $arr);
            }
        
            unset($v);
        }
        
        
        /*
        |--------------------------------------------------------------------------
        | Prime / Composite worksheet: order inside a value does NOT matter
        |--------------------------------------------------------------------------
        */
        if ($pc_is_unordered) {
            $correct_values = array_map('normalizeUnordered', $correct_values);
            $student_values = array_map('normalizeUnordered', $student_values);
        }
        
        
           /*
        |--------------------------------------------------------------------------
        | bodmas_fill_blank : ORDER MATTERS
        | Every blank sits in a fixed position, so compare position-by-position
        | WITHOUT sorting. This makes "1,1,2" WRONG when the answer is "2,1,1".
        |--------------------------------------------------------------------------
        */
        if ($question_type === 'bodmas_fill_blank') {

            if (count($correct_values) !== count($student_values)) {
                $is_correct = 0;
            } else {
                $is_correct = 1;
                foreach ($correct_values as $i => $cv) {
                    if ((string)($student_values[$i] ?? null) !== (string)$cv) {
                        $is_correct = 0;
                        break;
                    }
                }
            }

        } else {

            /*
            |----------------------------------------------------------------------
            | Existing behaviour for ALL other templates (order-insensitive)
            |----------------------------------------------------------------------
            */
            sort($correct_values);
            sort($student_values);

            $is_correct = ($correct_values === $student_values) ? 1 : 0;
        }
    }
} elseif (is_array($submitted_json)) {

if (
    isExponentExpression($student_answer)
    || isExponentExpression($correct_answer)
) {

    $is_correct =
    (
        normalizeExponentExpression($student_answer)
        ===
        normalizeExponentExpression($correct_answer)
    ) ? 1 : 0;

} else {

    $is_correct =
    (
        normalizeMath($student_answer)
        ===
        normalizeMath($correct_answer)
    ) ? 1 : 0;
}
        } else {
            // Normal string comparison (old behavior)
 if ($pc_is_unordered) {

    $is_correct =
    (
        normalizeUnordered($student_answer)
        ===
        normalizeUnordered($correct_answer)
    ) ? 1 : 0;

} elseif (is_numeric($student_answer) && is_numeric($correct_answer)) {

    $tol = 0.001;

    $is_correct =
        abs((float)$student_answer - (float)$correct_answer) < $tol
        ? 1
        : 0;

} else {

    if (
        isExponentExpression($student_answer)
        || isExponentExpression($correct_answer)
    ) {

        $is_correct =
        (
            normalizeExponentExpression($student_answer)
            ===
            normalizeExponentExpression($correct_answer)
        )
        ? 1
        : 0;

    } else {

        $is_correct =
        (
            normalizeMath($student_answer)
            ===
            normalizeMath($correct_answer)
        )
        ? 1
        : 0;

    }
}

}
        }
        // FIX: ensure string before DB insert
        if (is_array($student_answer)) {
            $student_answer = json_encode($student_answer);
}
    // Insert the answer
    $stmt_insert->bind_param("iiisis", $student_id, $quiz_id, $question_id, $student_answer, $is_correct, $created_at);
    $stmt_insert->execute();
}

// Clean up session
unset($_SESSION[$sess_key]);
unset($_SESSION['quiz_answers']);
// Redirect to results
header("Location: check_answer.php?topic_id=" . $quiz_id);
exit;
ob_end_flush();
?>