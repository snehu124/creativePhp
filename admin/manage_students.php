<?php
include '../db_config.php';
$sql = "SELECT * FROM students ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Manage Students</title>

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
      -webkit-overflow-scrolling: touch;
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
      vertical-align: middle;
      font-size: 14px;
    }

    .table-hover tbody tr:hover {
      background: #f4f8ff;
    }

    /* Buttons */

    .btn-sm {
      margin: 2px;
      border-radius: 6px;
    }

    /* Modal */

    .modal-content {
      border-radius: 16px;
    }

    .modal-header {
      background: linear-gradient(45deg, #1e88e5, #42a5f5);
      color: white;
      border: none;
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
          Manage Students
        </h4>

        <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addStudentModal">
          <i class="bi bi-plus-circle"></i> Add Student
        </button>

      </div>


      <div class="table-wrapper">

        <table class="table table-bordered table-hover text-center align-middle">

          <thead>

            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Gender</th>
              <th>DOB</th>
              <th>Created</th>
              <th>Actions</th>
            </tr>

          </thead>

          <tbody>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>

              <tr>

                <td><?= htmlspecialchars($row['first_name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><?= $row['gender'] ?></td>
                <td><?= $row['dob'] ?></td>
                <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>

                <td>

                  <a href="dashboard.php?page=edit_student.php?id=<?= $row['id'] ?>"
                    class="btn btn-sm btn-outline-primary">

                    <i class="bi bi-pencil"></i>

                  </a>


                  <form method="POST"
                    action="delete_student.php"
                    style="display:inline;"
                    onsubmit="return confirm('Delete this student?');">

                    <input type="hidden" name="id" value="<?= $row['id'] ?>">

                    <button type="submit"
                      class="btn btn-sm btn-outline-danger">

                      <i class="bi bi-trash"></i>

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


  <!-- Add Student Modal -->

  <div class="modal fade" id="addStudentModal">

    <div class="modal-dialog">

      <form action="add_student.php" method="POST" class="modal-content">

        <div class="modal-header">

          <h5>Add New Student</h5>

          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

        </div>


        <div class="modal-body">

          <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Gender</label>
            <select name="gender" class="form-control" required>
              <option value="">Select</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>

          <div class="mb-3">
            <label>DOB</label>
            <input type="date" name="dob" class="form-control" required>
          </div>

        </div>

        <div class="modal-footer">

          <button type="submit" class="btn btn-success">
            Add Student
          </button>

        </div>

      </form>

    </div>

  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>