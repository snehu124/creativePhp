<?php
include "../../db_config.php";

$total=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM invoices"))['c'];
$paid=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM invoices WHERE status='Paid'"))['c'];
$pending=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM invoices WHERE status='Pending'"))['c'];

$recent=mysqli_query($conn,"
SELECT invoices.*, enrollment_inquiries.first_name
FROM invoices
LEFT JOIN enrollment_inquiries
ON invoices.student_id=enrollment_inquiries.id
ORDER BY invoices.id DESC
LIMIT 5
");
?>

<div class="invoice-dashboard">

<h2 class="dashboard-title">
<i class="bi bi-receipt"></i> Invoice Dashboard
</h2>

<!-- Stats Cards -->

<div class="stats-grid">

<div class="stat-card total">
<div class="stat-icon">
<i class="bi bi-file-earmark-text"></i>
</div>

<div>
<h3>Total Invoices</h3>
<h1><?php echo $total ?></h1>
</div>
</div>


<div class="stat-card paid">
<div class="stat-icon">
<i class="bi bi-check-circle"></i>
</div>

<div>
<h3>Paid</h3>
<h1><?php echo $paid ?></h1>
</div>
</div>


<div class="stat-card pending">
<div class="stat-icon">
<i class="bi bi-hourglass-split"></i>
</div>

<div>
<h3>Pending</h3>
<h1><?php echo $pending ?></h1>
</div>
</div>

</div>


<!-- Recent invoices -->

<div class="invoice-table">

<h4>Recent Invoices</h4>

<table class="table table-hover">

<thead>

<tr>
<th>Invoice</th>
<th>Student</th>
<th>Total</th>
<th>Status</th>
<th>Action</th>
</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($recent)){ ?>

<tr>

<td><?php echo $row['invoice_number']?></td>

<td><?php echo $row['first_name']?></td>

<td>$<?php echo $row['total']?></td>

<td>

<?php if($row['status']=="Paid"){ ?>

<span class="badge bg-success">Paid</span>

<?php } else { ?>

<span class="badge bg-warning text-dark">Pending</span>

<?php } ?>

</td>

<td>

<a class="btn btn-sm btn-primary"
href="teacher_dashboard.php?page=invoice_system/invoice/invoice_view.php&id=<?php echo $row['id']; ?>">

View

</a>

<a class="menu-link btn btn-sm btn-success" style = "margin-left:20px"
href="teacher_dashboard.php?page=invoice_system/payments/record_payment.php&invoice_id=<?php echo $row['id']; ?>">

<i class="bi bi-cash"></i> Pay
</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>


<style>

.invoice-dashboard{
padding:10px;
}

.dashboard-title{
font-weight:600;
margin-bottom:25px;
color:#05364d;
}

/* Stats grid */

.stats-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:20px;
margin-bottom:30px;
}

.stat-card{
display:flex;
align-items:center;
gap:15px;
padding:20px;
border-radius:15px;
color:white;
box-shadow:0 6px 18px rgba(0,0,0,0.08);
}

.stat-card h3{
font-size:16px;
margin:0;
}

.stat-card h1{
font-size:28px;
margin:0;
}

/* Card colors */

.total{
background:linear-gradient(180deg, #1e3c72, #2a5298);
}

.paid{
background:linear-gradient(135deg,#11998e,#38ef7d);
}

.pending{
background:linear-gradient(135deg,#ff9966,#ff5e62);
}

/* Icons */

.stat-icon{
font-size:30px;
background:rgba(255,255,255,0.2);
padding:12px;
border-radius:10px;
}

/* Table */

.invoice-table{
background:white;
padding:20px;
border-radius:15px;
box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.invoice-table h4{
margin-bottom:15px;
font-weight:600;
}

</style>