<?php
include '../db_config.php';

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$id = intval($_GET['id']);

$result = mysqli_query($conn, "SELECT * FROM teachers WHERE id = $id");
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Teacher not found");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);

    $update = "UPDATE teachers 
               SET name='$name', email='$email', subject='$subject' 
               WHERE id=$id";

    if (mysqli_query($conn, $update)) {
        echo "<script>alert('Teacher updated successfully'); window.location='manage_teachers.php';</script>";
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Edit Teacher</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f4f7fb;
            font-family: 'Poppins', 'Segoe UI', sans-serif;
        }

        /* Card */

        .page-card {
            max-width: 700px;
            margin: auto;
            margin-top: 40px;
            background: white;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .05);
        }

        /* Title */

        .page-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;

            background: linear-gradient(45deg, #1e88e5, #42a5f5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Inputs */

        .form-control {
            border-radius: 10px;
            padding: 10px 12px;
            border: 1px solid #e0e6ed;
        }

        .form-control:focus {
            box-shadow: 0 0 0 2px rgba(30, 136, 229, .15);
            border-color: #42a5f5;
        }

        /* Buttons */

        .btn-update {
            background: linear-gradient(45deg, #1e88e5, #42a5f5);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            color: white;
            font-weight: 500;
        }

        .btn-update:hover {
            opacity: .9;
            color: white;
        }

        .btn-back {
            border-radius: 8px;
            padding: 10px 20px;
        }

        /* Responsive */

        @media(max-width:768px) {

            .page-card {
                padding: 20px;
                margin-top: 20px;
            }

            .page-title {
                font-size: 20px;
            }

        }
    </style>

</head>

<body>

    <div class="container-fluid">

        <div class="page-card">

            <h3 class="page-title">
                <i class="bi bi-pencil-square"></i> Edit Teacher
            </h3>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">
                        <i class="bi bi-person"></i> Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="<?= htmlspecialchars($data['name']) ?>"
                        required>

                </div>


                <div class="mb-3">
                    <label class="form-label">
                        <i class="bi bi-envelope"></i> Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="<?= htmlspecialchars($data['email']) ?>"
                        required>

                </div>


                <div class="mb-4">
                    <label class="form-label">
                        <i class="bi bi-book"></i> Subject
                    </label>

                    <input
                        type="text"
                        name="subject"
                        class="form-control"
                        value="<?= htmlspecialchars($data['subject']) ?>"
                        required>

                </div>


                <div class="d-flex gap-2 flex-wrap">

                    <button type="submit" class="btn btn-update">
                        <i class="bi bi-check-circle"></i> Update Teacher
                    </button>

                    <a href="dashboard.php?page=manage_teachers.php" class="btn btn-secondary btn-back">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>

                </div>

            </form>

        </div>

    </div>

</body>

</html>