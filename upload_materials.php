<?php
include 'db_config.php';

$course_id = $_POST['course_id'];

// Handle PDF Upload
foreach ($_FILES['study_pdfs']['tmp_name'] as $key => $tmp_name) {
    if ($_FILES['study_pdfs']['error'][$key] === 0) {
        $file_name = $_FILES['study_pdfs']['name'][$key];
        $target_path = "uploads/courses/" . time() . "_" . basename($file_name);
        move_uploaded_file($tmp_name, $target_path);

        mysqli_query($conn, "INSERT INTO course_materials (course_id, file_type, file_path) 
                             VALUES ('$course_id', 'pdf', '$target_path')");
    }
}

// Handle Video Links
if (!empty($_POST['video_links'])) {
    foreach ($_POST['video_links'] as $link) {
        if (!empty(trim($link))) {
            mysqli_query($conn, "INSERT INTO course_materials (course_id, file_type, file_path) 
                                 VALUES ('$course_id', 'video', '$link')");
        }
    }
}

header("Location: manage_courses.php");
exit;
