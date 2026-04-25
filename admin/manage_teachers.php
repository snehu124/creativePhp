<?php
include '../db_config.php';

$sql = "SELECT * FROM teachers ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>Manage Teachers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f4f7fb;
            font-family: 'Poppins', 'Segoe UI', sans-serif;
        }

        /* Card */

        .page-card {
            background: white;
            border-radius: 18px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .05);
        }

        /* Header */

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .page-title {
            font-size: 22px;
            font-weight: 600;
            background: linear-gradient(45deg, #1e88e5, #42a5f5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Add Button */

        .btn-add {
            background: linear-gradient(45deg, #11998e, #38ef7d);
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            color: white;
        }

        .btn-add:hover {
            opacity: .9;
            color: white;
        }

        /* Table */

        .table-wrapper {
            overflow-x: auto;
            width: 100%;
        }

        .table {
            min-width: 900px;
            border-radius: 14px;
            overflow: hidden;
        }

        .table thead th {
            background: linear-gradient(45deg, #1e88e5, #42a5f5);
            color: white;
            border: none;
            white-space: nowrap;
            font-size: 14px;
        }

        .table td {
            white-space: nowrap;
            font-size: 14px;
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background: #f4f8ff;
        }

        /* Buttons */

        .btn-sm {
            margin: 2px;
            border-radius: 7px;
        }

        /* Badge */

        .badge {
            padding: 6px 14px;
            border-radius: 30px;
            font-weight: 600;
        }

        /* Responsive */

        @media(max-width:768px) {

            .page-title {
                font-size: 18px;
            }

            .table {
                min-width: 850px;
            }

        }

        @media(max-width:480px) {

            .table {
                min-width: 800px;
            }

        }

        @media(max-width:300px) {

            .table {
                min-width: 750px;
            }

        }
    </style>

</head>

<body>

    <div class="container-fluid mt-3">

        <div class="page-card">

            <div class="page-header">

                <h4 class="page-title">
                    Manage Teachers
                </h4>

                <!-- <a href="dashboard.php?page=add_teacher.php" class="btn btn-add btn-sm">
                    <i class="bi bi-plus-circle"></i> Add Teacher
                </a> -->
                <a href="javascript:void(0)"
                    class="btn btn-add btn-sm menu-link"
                    data-page="add_teacher.php">
                    <i class="bi bi-plus-circle"></i> Add Teacher
                </a>

            </div>


            <div class="table-wrapper">

                <table class="table table-bordered table-hover align-middle text-center">

                    <thead>

                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) { ?>

                            <tr id="row-<?= $row['id'] ?>">

                                <td><?= $i++ ?></td>

                                <td><?= htmlspecialchars($row['name']) ?></td>

                                <td><?= htmlspecialchars($row['email']) ?></td>

                                <td><?= htmlspecialchars($row['subject']) ?></td>

                                <td>

                                    <?php if ($row['status'] === 'active') { ?>

                                        <span class="badge bg-success">
                                            Active
                                        </span>

                                    <?php } else { ?>

                                        <span class="badge bg-secondary">
                                            Inactive
                                        </span>

                                    <?php } ?>

                                </td>

                                <td>
                                    <?= date('d M Y', strtotime($row['created_at'])) ?>
                                </td>

                                <td>

                                    <a href="dashboard.php?page=edit_teacher.php?id=<?= $row['id'] ?>"
                                        class="btn btn-sm btn-outline-primary">

                                        <i class="bi bi-pencil"></i>

                                    </a>


                                    <button class="delete-btn btn btn-sm btn-outline-danger"
                                        data-id="<?= $row['id'] ?>">

                                        <i class="bi bi-trash"></i>

                                    </button>


                                    <?php if ($row['status'] === 'active') { ?>

                                        <button
                                            class="status-btn btn btn-sm btn-outline-warning"
                                            data-id="<?= $row['id'] ?>"
                                            data-status="inactive">

                                            Deactivate

                                        </button>

                                    <?php } else { ?>

                                        <button
                                            class="status-btn btn btn-sm btn-outline-success"
                                            data-id="<?= $row['id'] ?>"
                                            data-status="active">

                                            Activate

                                        </button>

                                    <?php } ?>

                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).on('click', '.delete-btn', function() {

            let teacherId = $(this).data('id');

            if (confirm('Are you sure you want to delete this teacher?')) {

                $.ajax({

                    url: 'Remove_teacher.php',
                    type: 'POST',
                    data: {
                        id: teacherId
                    },

                    success: function(res) {

                        let result = JSON.parse(res);

                        if (result.status) {

                            alert('Teacher deleted!');
                            $('#row-' + teacherId).fadeOut();

                        } else {

                            alert('Delete failed!');

                        }

                    }

                });

            }

        });


        $(document).on('click', '.status-btn', function() {

            let id = $(this).data('id');
            let status = $(this).data('status');

            $.ajax({

                url: 'update_teacher_status.php',
                type: 'POST',
                data: {
                    id: id,
                    status: status
                },

                success: function(res) {

                    let result = JSON.parse(res);

                    if (result.status) {

                        alert('Status updated!');
                        location.reload();

                    } else {

                        alert('Update failed!');

                    }

                }

            });

        });
    </script>

</body>

</html>