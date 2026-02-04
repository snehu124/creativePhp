<?php
session_start();
include "../db_config.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$subject_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$topic_id   = isset($_GET['topic_id']) ? intval($_GET['topic_id']) : 0;

if ($subject_id == 0) {
    die("Invalid subject ID");
}

$student_id = $_SESSION['student_id'] ?? 1; // testing ke liye

// get the name of the student
$sqlName = "SELECT first_name FROM students WHERE id= ?";
$stmtName = $conn->prepare($sqlName);
$stmtName->bind_param("i", $student_id);
$stmtName->execute();
$resultName = $stmtName->get_result();
$rowName = $resultName->fetch_assoc();
$studentName = $rowName['first_name'] ?? 'Student';

// Topics fetch
$selected_topic = null;
$quiz_questions = [];
if ($topic_id) {
    $sql3 = "SELECT title, content, video_path FROM topics WHERE id = ?";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bind_param("i", $topic_id);
    $stmt3->execute();
    $result3 = $stmt3->get_result();
    $selected_topic = $result3->fetch_assoc();

    // Quiz questions fetch
    $sql4 = "SELECT * FROM quiz_questions WHERE topic_id = ? ORDER BY id ASC";
    $stmt4 = $conn->prepare($sql4);
    $stmt4->bind_param("i", $topic_id);
    $stmt4->execute();
    $result4 = $stmt4->get_result();
    while ($row = $result4->fetch_assoc()) {
        $quiz_questions[] = $row;
    }
}

if(!empty($quiz_questions)){
    $current = isset($_GET['q']) ? intval($_GET['q']) : 0;
    $total = count($quiz_questions);
    $q = $quiz_questions[$current]; 
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="student.css" rel="stylesheet"/>
  <title>Student Dashboard</title>
  <style>
    body {
      background: linear-gradient(135deg, #7F7FD5, #86A8E7, #91EAE4);
      min-height: 100vh;
      font-family: 'Segoe UI', sans-serif;
    }
    .quiz-box {
      background: #fff;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
      margin-top: 40px;
      animation: fadeIn 0.6s ease-in-out;
    }
    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(20px);}
      to {opacity: 1; transform: translateY(0);}
    }
    .quiz-options label {
      display: block;
      background: #f9f9f9;
      border: 2px solid transparent;
      border-radius: 10px;
      padding: 12px 18px;
      margin: 10px 0;
      cursor: pointer;
      transition: 0.3s;
      font-weight: 500;
    }
    .quiz-options input {
      margin-right: 10px;
    }
    .quiz-options label:hover {
      background: #e3f2fd;
      border-color: #64b5f6;
    }
    .quiz-options input:checked + span {
      color: #0d47a1;
      font-weight: bold;
    }
    .next-btn {
      background: linear-gradient(45deg, #ff416c, #ff4b2b);
      border: none;
      padding: 12px 28px;
      border-radius: 10px;
      color: #fff;
      font-size: 16px;
      font-weight: bold;
      transition: 0.3s;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .next-btn:hover {
      background: linear-gradient(45deg, #ff1744, #d50000);
      transform: scale(1.05);
    }
    .progress-info {
      font-size: 14px;
      color: #555;
      margin-bottom: 15px;
    }
    .explainations {
      height: 50px;
      background-color: beige;
    }
    .score {
      height: 50px;
      background-color: bisque;
    }
    .img-container {
      height: 150px;
    }
  </style>
</head>
<body>
    <section class="main">
        <div class="explainations d-flex justify-content-between align-items-center px-5">
            <a href="#">See Explanation</a>
            <div class="flex-column justify-content-between align-items-center">
                <h6>Quiz: <?= htmlspecialchars($selected_topic['title']) ?></h6>
                <small><?= htmlspecialchars($selected_topic['content']) ?></small>
            </div>
            <!-- Watch Video Button -->
            <?php if (!empty($selected_topic['video_path'])): ?>
              <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#videoModal">
                Watch Video
              </a>
            <?php endif; ?>
        </div>
        
        <div class="score d-flex justify-content-between align-items-center px-5">
           <?php if (!isset($_SESSION['score'])) $_SESSION['score'] = 0;
            ?>
            <h6 id="score-result">Score: <?= intval($_SESSION['score']) ?></h6>
            <h6>Question: <?= $total ?></h6>
            <h6>Grade</h6>
        </div>
        
        <div class="fluid-container bg-white img-container d-flex justify-content-center align-items-center">
            <img src="#" alt="image-1">
            <img src="#" alt="image-2">
        </div>
        
        <form method="post" action="submit_quiz.php">
            <div class="mb-3">
              <h5><strong><?= $current+1 ?>.<?= htmlspecialchars($q['question_text'] ?? '') ?></strong></h5>
            </div>
          
            <div class="quiz-options d-flex justify-content-between align-items-center px-5 py-5">
                <button type="button" class="quiz-option" data-question="<?= $q['id']?>" data-answer="A"><?= htmlspecialchars($q['option_a'] ??'')?></button>
                <button type="button" class="quiz-option" data-question="<?= $q['id']?>" data-answer="B"><?= htmlspecialchars($q['option_b'] ??'')?></button>
                <button type="button" class="quiz-option" data-question="<?= $q['id']?>" data-answer="C"><?= htmlspecialchars($q['option_c'] ??'')?></button>
                <button type="button" class="quiz-option" data-question="<?= $q['id']?>" data-answer="D"><?= htmlspecialchars($q['option_d'] ??'')?></button>
            </div>
            
            <div id="result-message" class="mt-3 fw-bold"></div>
           
            <div class="mt-4 text-end">
              <?php if($current < $total-1): ?>
                <a href="?topic_id=<?= $topic_id ?>&id=<?= $subject_id ?>&show_quiz=1&q=<?= $current+1 ?>" class="next-btn text-decoration-none">Next ➡</a>
              <?php endif; ?>
            </div>
            <!-- Video Modal -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered"> <!-- modal-lg for larger view -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="videoModalLabel"><?= htmlspecialchars($selected_topic['title'] ?? '') ?> - Video</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php if (!empty($selected_topic['video_path'])): ?>
          <?php 
            $video = $selected_topic['video_path'];

            // YouTube watch?v= link ko embed format me convert karna
            if (strpos($video, "youtube.com/watch") !== false) {
                $video_id = explode("v=", $video)[1];
                $video_id = explode("&", $video_id)[0]; // extra parameters remove
                $embed_url = "https://www.youtube.com/embed/" . $video_id;
            }
          ?>
          
          <div class="ratio ratio-16x9">
            <iframe src="<?= htmlspecialchars($embed_url ?? $video) ?>" 
                    title="Topic Video" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
            </iframe>
          </div>

        <?php else: ?>
          <p>No video available for this topic.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- Watch Video Button -->


    </section>    
    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', ()=> {
            document.querySelectorAll('.quiz-option').forEach(btn => {
                btn.addEventListener('click', function () {
                    const questionId =this.dataset.question;
                    const answer = this.dataset.answer;
                    
                           // disable this question's options to prevent multiple clicks
                        document.querySelectorAll(`.quiz-option[data-question="${questionId}"]`)
                        .forEach(o => o.disabled = true);
                    
                    
                    fetch('check_answer.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `question_id=${encodeURIComponent(questionId)}&answer=${encodeURIComponent(answer)}`
                    })
                    
                    .then(res=> res.json())
                    .then(data => {
                        const scoreEl = document.getElementById('score-result');
                        const msgBox = document.getElementById('result-message');
                        if(data.correct){
                            msgBox.textContent = '✅ Correct!';
                            msgBox.className = 'text-success';
                            scoreEl.textContent = `Score:${data.score}`;
                        } else {
                            msgBox.textContent = '❌ Wrong!';
                            msgBox.className = 'text-danger';
                        } 
                    })
                    .catch(err => console.error(err));
                });
            });
        });
        
          var videoModal = document.getElementById('videoModal');

  videoModal.addEventListener('hidden.bs.modal', function () {
      var iframe = videoModal.querySelector('iframe');
      if (iframe) {
    
          iframe.src = iframe.src;
      }
  });
    </script>
</body>
</html>
