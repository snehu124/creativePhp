<?php
include '../db_config.php';

// Fetch all courses
$sql = "SELECT * FROM courses ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Courses</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fb;
        }

        /* Card */

        .page-card {
            background: white;
            padding: 25px;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, .05);
        }

        /* Header */

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
            background: linear-gradient(45deg, #1e88e5, #42a5f5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Button */

        .btn-add {
            background: linear-gradient(45deg, #1e88e5, #42a5f5);
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            color: white;
        }

        .btn-add:hover {
            opacity: .9;
            color: white;
        }

        /* Table */

        .table-wrapper {
            overflow-x: auto;
        }

        .table {
            min-width: 800px;
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead th {
            background: linear-gradient(45deg, #1e88e5, #42a5f5);
            color: white;
            border: none;
            padding: 14px;
            white-space: nowrap;
        }

        .table td {
            padding: 14px;
            white-space: nowrap;
        }

        .table tbody tr:hover {
            background: #f4f8ff;
        }

        /* Delete button */

        .btn-delete {
            background: linear-gradient(45deg, #ff416c, #ff4b2b);
            border: none;
            color: white;
            padding: 5px 12px;
            border-radius: 6px;
        }

        /* Modal */

        .modal-content {
            border-radius: 15px;
        }

        .modal-header {
            background: linear-gradient(45deg, #1e88e5, #42a5f5);
            color: white;
            border: none;
        }

        /* Responsive */

        @media(max-width:768px) {

            .page-title {
                font-size: 20px;
            }

        }

        @media(max-width:300px) {

            .table {
                min-width: 700px;
            }

        }
    </style>

</head>

<body>

    <div class="container-fluid mt-3">

        <div class="page-card">

            <div class="page-header">

                <h4 class="page-title">Manage Courses</h4>

                <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addModal">
                    + Add Course
                </button>

            </div>


            <div class="table-wrapper">

                <table class="table table-bordered align-middle">

                    <thead>

                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                            <tr>

                                <td><?= htmlspecialchars($row['title']) ?></td>

                                <td><?= htmlspecialchars($row['description']) ?></td>

                                <td>₹<?= number_format($row['price'], 2) ?></td>

                                <td><?= $row['created_by'] ?></td>

                                <td>

                                    <form method="POST" action="delete_course.php"
                                        onsubmit="return confirm('Delete this course?');">

                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">

                                        <button type="submit" class="btn btn-delete btn-sm">
                                            Delete
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <!-- Add Modal -->

    <div class="modal fade" id="addModal" tabindex="-1">

        <div class="modal-dialog">

            <form action="add_course.php" method="POST" class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">Add New Course</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Course Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Price (₹)</label>
                        <input type="number" name="price" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Created By (Teacher ID)</label>
                        <input type="number" name="created_by" class="form-control" required>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="submit" class="btn btn-success">
                        Add Course
                    </button>

                </div>

            </form>

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>