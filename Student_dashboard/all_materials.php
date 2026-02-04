<?php
session_start();
include '../db_config.php';
include 'student_sidebar.php';


$sql = "SELECT m.*, c.title AS course_title, c.created_by 
        FROM course_materials m 
        JOIN courses c ON m.course_id = c.id 
        ORDER BY m.uploaded_at DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>All Study Materials</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
<link href = "student.css" rel ="stylesheet">

<style>

  .title-bar { margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
  .title-bar h2 { font-weight: 600; color: black; }

  /* Card Design */
  .subject-card {
    background: #fff2f4; /* Light soft red */
    border-radius: 16px;
    text-align: center;
    padding: 32px 18px 64px;
    position: relative;
    height: 100%;
    transition: all .25s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,.08);
  }
  .subject-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 18px rgba(0,0,0,.12);
  }

  /* Tick Badge */
  .subject-card .tick-icon {
    position: absolute;
    top: -14px;
    left: 50%;
    transform: translateX(-50%);
    width: 38px;
    height: 38px;
    background: #e8063c;
    color: #fff;
    border: 3px solid #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    box-shadow: 0 2px 6px rgba(0,0,0,.15);
  }

  /* File icon box */
  .subject-card .file-thumb {
    width: 70px;
    height: 70px;
    margin: 0 auto 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ffffff; /* Changed to white */
    border-radius: 12px;
    box-shadow: 0 1px 4px rgba(0,0,0,.08);
  }
  .subject-card .file-thumb img {
    max-width: 38px;
    height: auto;
    filter: none; /* Remove invert for normal color */
  }

  .subject-card h5 {
    font-size: 1rem;
    font-weight: 600;
    color: black;
    margin-bottom: 6px;
  }

  .subject-card .file-name {
    display: block;
    font-size: .85rem;
    color:black;
    word-break: break-all;
  }

  /* Actions */
  .subject-card .actions {
    position: absolute;
    bottom: 16px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 10px;
  }
  .subject-card .actions a {
    --btn-size: 36px;
    width: var(--btn-size);
    height: var(--btn-size);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: #1f669c;
    background: #fff;
    border: 2px solid #1f669c;
    text-decoration: none;
    transition: all .2s ease;
  }
  .subject-card .actions a:hover {
    color: #fff;
    background: #1f669c;
    border-color: #1f669c;
    transform: scale(1.05);
  }
  .subject-card .actions a.delete:hover {
    background: #e8063c;
    border-color: #e8063c;
  }

  @media (max-width:575.98px) {
    .subject-card { padding: 28px 16px 60px; }
    .subject-card .actions { gap: 8px; }
  }
</style>
</head>
<body>

<div class="main">
  <div class="title-bar">
    <h2>All Study Materials</h2>
  </div>

  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
    <?php
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $file_name = basename($row['file_path']);
        $course    = htmlspecialchars($row['course_title']);
        $id        = (int)$row['id'];
    ?>
    <div class="col">
      <div class="subject-card">
        <div class="tick-icon"><i class="fa-solid fa-check"></i></div>
        <div class="file-thumb">
          <img src="uploads/pdf.png" alt="PDF">
        </div>
        <h5><?= $course ?></h5>
        <span class="file-name"><?= $file_name ?></span>

        <div class="actions">
          <a href="<?= $row['file_path'] ?>" target="_blank" title="View"><i class="fa-regular fa-eye"></i></a>
          <a href="<?= $row['file_path'] ?>" download title="Download"><i class="fa-solid fa-download"></i></a>
          <a href="courses_meterial/edit_material.php?id=<?= $id ?>" title="Edit"><i class="fa-regular fa-pen-to-square"></i></a>
          <a href="courses_meterial/delete_material.php?id=<?= $id ?>" class="delete" onclick="return confirm('Delete this file?');" title="Delete"><i class="fa-regular fa-trash-can"></i></a>
        </div>
      </div>
    </div>
    <?php
      }
    } else {
      echo "<p>No materials found.</p>";
    }
    ?>
  </div>
</div>

</body>
</html>