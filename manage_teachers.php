<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// include 'header.php'; // Bootstrap & nav included
include 'db_config.php';

// Fetch teachers from DB
$sql = "SELECT * FROM teachers ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Teachers</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #eef2f8;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card {
      border: none;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      padding: 30px;
    }

    h3.text-primary {
      font-weight: 700;
      font-size: 1.9rem;
    }

    .btn-success {
      font-weight: 600;
      padding: 10px 20px;
      font-size: 14px;
      border-radius: 8px;
    }

    .table thead th {
      background-color: #0d6efd;
      color: #fff;
      font-size: 14px;
      vertical-align: middle;
    }

    .table-hover tbody tr:hover {
      background-color: #f1f3f5;
      transform: scale(1.01);
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }

    .table td {
      vertical-align: middle;
      font-size: 14px;
      padding: 14px 12px;
    }

    .btn-sm {
      font-size: 13px;
      padding: 6px 12px;
      border-radius: 6px;
    }

    .btn-outline-danger {
      border-color: #dc3545;
      color: #dc3545;
    }

    .btn-outline-danger:hover {
      background-color: #dc3545;
      color: white;
    }

    .badge {
      padding: 6px 12px;
      font-size: 13px;
      font-weight: 600;
      border-radius: 50px;
    }

    @media (max-width: 576px) {
      h3.text-primary {
        font-size: 1.4rem;
      }

      .btn-sm {
        font-size: 12px;
        padding: 5px 10px;
      }

      .table td, .table th {
        font-size: 12px;
        padding: 10px;
      }
    }
  </style>
</head>
<body>

<div class="container my-5">
  <div class="card">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="mb-0 text-primary">Manage Teachers</h3>
      <a href="add_teacher.php" class="btn btn-success btn-sm">
        <i class="bi bi-plus-circle"></i> Add Teacher
      </a>
    </div>

    <div class="table-responsive">
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
          <?php $i = 1; while($row = mysqli_fetch_assoc($result)) { ?>
            <tr id="row-<?= $row['id'] ?>">
              <td><?= $i++ ?></td>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['subject']) ?></td>
              <td>
                <?php if ($row['status'] === 'active'): ?>
                  <span class="badge bg-success">Active</span>
                <?php else: ?>
                  <span class="badge bg-secondary">Inactive</span>
                <?php endif; ?>
              </td>
              <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
              <td>
                <button class="delete-btn btn btn-sm btn-outline-danger" data-id="<?= $row['id'] ?>">
                  <i class="bi bi-trash"></i> Delete
                </button>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>

<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Delete AJAX Script -->
<script>
  $(document).on('click', '.delete-btn', function () {
    let teacherId = $(this).data('id');
    if (confirm('Are you sure you want to delete this teacher?')) {
      $.ajax({
        url: 'Remove_teacher.php',
        type: 'POST',
        data: { id: teacherId },
        success: function (res) {
          let result = JSON.parse(res);
          if (result.status) {
            alert('✅ Teacher deleted successfully!');
            $('#row-' + teacherId).fadeOut();
          } else {
            alert('❌ Failed to delete teacher. Try again.');
          }
        },
        error: function () {
          alert('❌ Server error. Please try again.');
        }
      });
    }
  });
</script>

</body>
</html>
