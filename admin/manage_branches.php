<?php
include '../db_config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Manage Branches</title>

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
            box-shadow: 0 8px 25px rgba(0, 0, 0, .05);
            padding: 25px;
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
            font-weight: 600;
            font-size: 22px;
            background: linear-gradient(45deg, #1e88e5, #42a5f5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Add Button */

        .btn-add {
            background: linear-gradient(45deg, #11998e, #38ef7d);
            border: none;
            color: white;
            padding: 7px 16px;
            border-radius: 8px;
        }

        .btn-add:hover {
            color: white;
            opacity: .9;
        }

        /* Table */

        .table-wrapper {
            overflow-x: auto;
        }

        .table {
            min-width: 600px;
            border-radius: 14px;
            overflow: hidden;
        }

        .table thead th {
            background: linear-gradient(45deg, #1e88e5, #42a5f5);
            color: white;
            font-size: 14px;
            border: none;
            white-space: nowrap;
        }

        .table td {
            vertical-align: middle;
            font-size: 14px;
            white-space: nowrap;
        }

        .table-hover tbody tr:hover {
            background: #f4f8ff;
        }

        /* Buttons */

        .btn-outline-primary {
            border-radius: 6px;
        }

        .btn-outline-danger {
            border-radius: 6px;
        }

        /* Responsive */

        @media(max-width:768px) {

            .page-title {
                font-size: 18px;
            }

            .table {
                min-width: 550px;
            }

        }

        @media(max-width:480px) {

            .table {
                min-width: 500px;
            }

        }

        @media(max-width:300px) {

            .table {
                min-width: 450px;
            }

        }
    </style>

</head>

<body>

    <div class="container-fluid mt-3">

        <div class="page-card">

            <div class="page-header">

                <h4 class="page-title">
                    Manage Branches
                </h4>

                <a href="dashboard.php?page=add_branch.php" class="btn btn-add btn-sm">
                    <i class="bi bi-plus-circle"></i> Add Branch
                </a>

            </div>


            <div class="table-wrapper">

                <table class="table table-bordered table-hover text-center align-middle">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Branch Name</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM branches ORDER BY id DESC");

                        if (mysqli_num_rows($query) > 0) {

                            while ($row = mysqli_fetch_assoc($query)) {
                        ?>

                                <tr id="row-<?= $row['id'] ?>">

                                    <td><?= $row['id'] ?></td>

                                    <td>
                                        <strong><?= htmlspecialchars($row['branch_name']) ?></strong>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['branch_address']) ?>
                                    </td>

                                    <td>

                                        <a href="dashboard.php?page=edit_branch.php?id=<?= $row['id'] ?>"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <button class="delete-btn btn btn-sm btn-outline-danger" data-id="<?= $row['id'] ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </td>

                                </tr>

                            <?php
                            }
                        } else {
                            ?>

                            <tr>
                                <td colspan="4" class="text-muted">
                                    No branches found
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

            let id = $(this).data('id');

            if (confirm('Delete this branch?')) {

                $.ajax({

                    url: 'delete_branch.php',
                    type: 'POST',
                    data: {
                        id: id
                    },

                    success: function(res) {

                        let result = JSON.parse(res);

                        if (result.status) {

                            alert('Branch deleted!');
                            $('#row-' + id).fadeOut();

                        } else {

                            alert('Delete failed!');

                        }

                    }

                });

            }

        });
    </script>

</body>

</html>