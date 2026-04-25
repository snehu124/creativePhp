<?php
include '../db_config.php';

if (!isset($_GET['id'])) {
  die("Invalid Request");
}

$id = intval($_GET['id']);

$result = mysqli_query($conn, "SELECT * FROM branches WHERE id=$id");
$data = mysqli_fetch_assoc($result);

if (!$data) {
  die("Branch not found");
}

if (isset($_POST['update'])) {
  $name = mysqli_real_escape_string($conn, $_POST['branch_name']);
  $address = mysqli_real_escape_string($conn, $_POST['branch_address']);

  mysqli_query($conn, "UPDATE branches 
    SET branch_name='$name', branch_address='$address' 
    WHERE id=$id");

  header("Location: manage_branches.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Edit Branch</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: #f4f7fb;
      font-family: 'Poppins', 'Segoe UI', sans-serif;
    }

    /* Card */

    .form-card {
      max-width: 600px;
      margin: auto;
      margin-top: 50px;
      padding: 30px;
      border-radius: 18px;
      background: white;
      box-shadow: 0 8px 30px rgba(0, 0, 0, .05);
    }

    /* Header */

    .form-title {
      font-weight: 600;
      font-size: 22px;
      margin-bottom: 20px;
      background: linear-gradient(45deg, #1e88e5, #42a5f5);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    /* Inputs */

    .form-control {
      border-radius: 10px;
      padding: 10px 12px;
      border: 1px solid #e5e7eb;
    }

    .form-control:focus {
      box-shadow: 0 0 0 3px rgba(30, 136, 229, .15);
      border-color: #1e88e5;
    }

    /* Buttons */

    .btn-update {
      background: linear-gradient(45deg, #1e88e5, #42a5f5);
      border: none;
      padding: 8px 18px;
      border-radius: 8px;
      color: white;
    }

    .btn-update:hover {
      opacity: .9;
      color: white;
    }

    .btn-back {
      border-radius: 8px;
      padding: 8px 18px;
    }

    /* Responsive */

    @media(max-width:768px) {

      .form-card {
        margin-top: 30px;
        padding: 22px;
      }

      .form-title {
        font-size: 20px;
      }

    }

    @media(max-width:480px) {

      .form-card {
        padding: 18px;
      }

    }

    @media(max-width:300px) {

      .form-card {
        padding: 15px;
      }

    }
  </style>

</head>

<body>

  <div class="container-fluid">

    <div class="form-card">

      <h4 class="form-title">
        Edit Branch
      </h4>

      <form method="POST">

        <div class="mb-3">

          <label class="form-label fw-semibold">
            Branch Name
          </label>

          <input
            type="text"
            name="branch_name"
            class="form-control"
            value="<?= htmlspecialchars($data['branch_name']) ?>"
            required>

        </div>


        <div class="mb-3">

          <label class="form-label fw-semibold">
            Branch Address
          </label>

          <textarea
            name="branch_address"
            class="form-control"
            rows="4">

<?= htmlspecialchars($data['branch_address']) ?>

</textarea>

        </div>


        <div class="d-flex gap-2 flex-wrap">

          <button
            type="submit"
            name="update"
            class="btn btn-update">

            Update Branch

          </button>

          <a href="dashboard.php?page=manage_branches.php"
            class="btn btn-secondary btn-back">

            Back

          </a>

        </div>

      </form>

    </div>

  </div>

</body>

</html>