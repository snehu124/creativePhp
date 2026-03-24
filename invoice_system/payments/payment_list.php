<?php
include "../../db_config.php";

$result=mysqli_query($conn,"
SELECT payments.*, enrollment_inquiries.first_name
FROM payments
LEFT JOIN invoices ON payments.invoice_id=invoices.id
LEFT JOIN enrollment_inquiries ON invoices.student_id=enrollment_inquiries.id
ORDER BY payments.id DESC
");
?>

<div class="payment-page">

<div class="page-header">

<h2>
<i class="bi bi-cash-coin"></i>
Payments
</h2>

</div>

<div class="payment-card">

<table class="table table-hover align-middle">

<thead>

<tr>
<th>Sr No</th>
<th>Student</th>
<th>Amount</th>
<th>Method</th>
<th>Date</th>
<th>Receipt</th>
</tr>

</thead>

<tbody>

<?php 
$sr = 1; 
while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td>
<b><?php echo $sr++; ?></b>
</td>

<td>
<?php echo $row['first_name']?>
</td>

<td>
$<?php echo $row['amount']?>
</td>

<td>

<span class="badge bg-info text-dark">

<?php echo $row['payment_method']?>

</span>

</td>

<td>
<?php echo $row['payment_date']?>
</td>

<td>

<a class="btn btn-sm btn-primary"

href="invoice_system/payments/generate_receipt_pdf.php?payment_id=<?php echo $row['id']?>"

target="_blank">

<i class="bi bi-file-earmark-pdf"></i>

Receipt

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>


<style>

.payment-page{
padding:10px;
}

.page-header{
margin-bottom:20px;
}

.page-header h2{
font-weight:600;
color:#05364d;
}

.payment-card{
background:white;
padding:20px;
border-radius:15px;
box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

</style>