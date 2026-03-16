<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include 'db_config.php';


/*
|--------------------------------------------------------------------------
| AUTH CHECK
|--------------------------------------------------------------------------
*/

if (
    !isset($_SESSION['teacher_id']) ||
    !isset($_SESSION['teacher_subject'])
) {

    echo "
        <div class='alert alert-danger'>
            Unauthorized access.
        </div>
    ";

    exit;

}

$teacher_id = $_SESSION['teacher_id'];
$subject    = $_SESSION['teacher_subject'];


/*
|--------------------------------------------------------------------------
| FETCH STUDENTS
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT
        s.id,
        s.first_name,
        s.parent_email
    FROM students s
    INNER JOIN subjects sub
        ON s.grade = sub.grade
    WHERE
        sub.subject_name = ?
        AND s.parent_email IS NOT NULL
";

$stmt = $conn->prepare($sql);

$stmt->bind_param("s", $subject);

$stmt->execute();

$students_q = $stmt->get_result();

?>


<style>

.email-container
{
    width: 100%;
    margin: 0;
}


.email-title
{
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 20px;
}

</style>



<div class="email-container">

    <div style="display:flex;justify-content:space-between;align-items:center;">

        <h4 class="email-title">
            <i class="bi bi-envelope-fill"></i>
            Send Email Updates
        </h4>

    </div>


    <form
        method="POST"
        action="send_email_action.php"
        enctype="multipart/form-data"
    >


        <!-- STUDENT -->
        <div class="mb-3">

            <label class="form-label">
                Select Student
            </label>

            <select
                name="student_email"
                class="form-select"
                required
            >

                <option value="">
                    Select Student
                </option>

                <?php while ($row = $students_q->fetch_assoc()): ?>

                    <option value="<?= htmlspecialchars($row['parent_email']) ?>">

                        <?= htmlspecialchars($row['first_name']) ?>
                        (<?= htmlspecialchars($row['parent_email']) ?>)

                    </option>

                <?php endwhile; ?>

            </select>

        </div>



        <!-- SUBJECT -->
        <div class="mb-3">

            <label class="form-label">
                Email Subject
            </label>

            <input
                type="text"
                name="subject"
                class="form-control"
                required
            >

        </div>



        <!-- MESSAGE -->
        <div class="mb-3">

            <label class="form-label">
                Message
            </label>

            <textarea
                name="message"
                class="form-control"
                rows="5"
                required
            ></textarea>

        </div>



        <!-- ATTACHMENT -->
        <div class="mb-3">

            <label class="form-label">
                Attachment
            </label>

            <input
                type="file"
                name="attachment"
                class="form-control"
            >

        </div>



        <!-- BUTTON -->
        <button
            type="submit"
            class="btn btn-primary w-100"
        >

            <i class="bi bi-send"></i>
            Send Email

        </button>


    </form>

</div>