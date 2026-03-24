<?php
include "../../db_config.php";

$result=mysqli_query($conn,"
SELECT invoices.*, enrollment_inquiries.first_name, enrollment_inquiries.last_name
FROM invoices
LEFT JOIN enrollment_inquiries
ON invoices.student_id=enrollment_inquiries.id
ORDER BY invoices.id DESC
");
?>

<div class="invoice-page">

<div class="page-header">
<h2><i class="bi bi-file-earmark-text"></i> Invoice List</h2>
</div>

<div class="invoice-card">

<table class="table table-hover align-middle">

<thead>

<tr>
<th>Invoice</th>
<th>Student</th>
<th>Amount</th>
<th>Status</th>
<th>Date</th>
<th>Action</th>
</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td>
<b><?php echo $row['invoice_number']?></b>
</td>

<td>
<?php echo $row['first_name']?> <?php echo $row['last_name']?>
</td>

<td>
$<?php echo $row['total']?>
</td>

<td>

<?php if($row['status']=="Paid"){ ?>

<span class="badge bg-success">Paid</span>

<?php } else { ?>

<span class="badge bg-warning text-dark">Pending</span>

<?php } ?>

</td>

<td>
<?php echo $row['invoice_date']?>
</td>

<td>

<a class="btn btn-primary btn-sm"
href="teacher_dashboard.php?page=invoice_system/invoice/invoice_view.php&id=<?php echo $row['id']; ?>">
View
</a>

<a class="menu-link btn btn-sm btn-success"
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

.invoice-page{
padding:10px;
}

.page-header{
margin-bottom:20px;
}

.page-header h2{
font-weight:600;
color:#05364d;
}

.invoice-card{
background:white;
padding:20px;
border-radius:15px;
box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

</style>