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


/*
|--------------------------------------------------------------------------
| GET SUBJECT FROM SESSION
|--------------------------------------------------------------------------
*/

$subject = $_SESSION['teacher_subject'];


/*
|--------------------------------------------------------------------------
| FETCH STUDENTS
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT
        s.first_name AS name,
        s.email,
        s.phone,
        s.gender,
        s.dob
    FROM students s
    INNER JOIN subjects sub
        ON s.grade = sub.grade
    WHERE sub.subject_name = ?
";


$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "s",
    $subject
);

$stmt->execute();

$result = $stmt->get_result();

?>


<style>

/* Container */
.students-container
{
    padding: 5px;
}


/* Header */
.students-header
{
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}


.header-left
{
    display: flex;
    align-items: center;
    gap: 12px;
}


.header-icon
{
    width: 48px;
    height: 48px;
    background: #2563eb;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 22px;
}


.header-title
{
    margin: 0;
    font-size: 22px;
    font-weight: 600;
}


.header-subtitle
{
    margin: 0;
    font-size: 14px;
    color: #6b7280;
}


.subject-badge
{
    background: #2563eb;
    color: white;
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 14px;
}


/* Table */
.students-table
{
    width: 100%;
    border-collapse: collapse;
}


.students-table th
{
    background: #0f172a;
    color: white;
    padding: 14px;
    text-align: left;
}


.students-table td
{
    padding: 14px;
    border-bottom: 1px solid #e5e7eb;
}


.students-table tr:hover
{
    background: #f8fafc;
}


/* Avatar */
.student-cell
{
    display: flex;
    align-items: center;
    gap: 10px;
}


.avatar
{
    width: 36px;
    height: 36px;
    background: #2563eb;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}


/* Gender badge */
.gender-badge
{
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 12px;
}


.gender-male
{
    background: #06b6d4;
    color: white;
}


.gender-female
{
    background: #ec4899;
    color: white;
}

</style>



<div class="students-container">


    <!-- HEADER -->
    <div class="students-header">

        <div class="header-left">

            <div class="header-icon">
                <i class="bi bi-people-fill"></i>
            </div>

            <div>

                <h4 class="header-title">
                    My Students
                </h4>

                <p class="header-subtitle">
                    View and manage student information
                </p>

            </div>

        </div>


        <div class="subject-badge">

            Subject: <?= htmlspecialchars($subject) ?>

        </div>

    </div>



    <!-- TABLE -->
    <?php if ($result->num_rows > 0): ?>

        <table class="students-table">

            <thead>

                <tr>

                    <th>Sr No</th>

                    <th>Student</th>

                    <th>Email</th>

                    <th>Phone</th>

                    <th>Gender</th>

                    <th>DOB</th>

                </tr>

            </thead>

            <tbody>

                <?php
                $i = 1;

                while ($row = $result->fetch_assoc()):
                ?>

                    <tr>

                        <td>
                            <?= $i ?>
                        </td>


                        <td>

                            <div class="student-cell">

                                <div class="avatar">
                                    <?= strtoupper(substr($row['name'], 0, 1)) ?>
                                </div>

                                <?= htmlspecialchars($row['name']) ?>

                            </div>

                        </td>


                        <td>
                            <?= htmlspecialchars($row['email']) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars($row['phone']) ?>
                        </td>


                        <td>

                            <?php if ($row['gender'] == "male"): ?>

                                <span class="gender-badge gender-male">
                                    Male
                                </span>

                            <?php else: ?>

                                <span class="gender-badge gender-female">
                                    Female
                                </span>

                            <?php endif; ?>

                        </td>


                        <td>
                            <?= htmlspecialchars($row['dob']) ?>
                        </td>

                    </tr>

                <?php

                $i++;

                endwhile;

                ?>

            </tbody>

        </table>

    <?php else: ?>

        <div style="padding:40px;text-align:center;color:#6b7280;">

            No students found

        </div>

    <?php endif; ?>


</div>
