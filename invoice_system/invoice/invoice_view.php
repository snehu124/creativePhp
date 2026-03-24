<?php
include "../../db_config.php";

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT invoices.*, enrollment_inquiries.*
FROM invoices
JOIN enrollment_inquiries
ON invoices.student_id=enrollment_inquiries.id
WHERE invoices.id='$id'
"));
?>

<div class="invoice-view-page">

<div class="invoice-header">
<h3><i class="bi bi-receipt"></i> Invoice Details</h3>
</div>

<div class="invoice-card">

<div class="invoice-grid">

<div class="info-box">
<label>Invoice Number</label>
<p><?php echo $data['invoice_number']?></p>
</div>

<div class="info-box">
<label>Student</label>
<p><?php echo $data['first_name']?> <?php echo $data['last_name']?></p>
</div>

<div class="info-box">
<label>Total Amount</label>
<p>$<?php echo $data['total']?></p>
</div>

<div class="info-box">
<label>Status</label>

<?php if($data['status']=="Paid"){ ?>

<span class="badge bg-success">Paid</span>

<?php } else { ?>

<span class="badge bg-warning text-dark">Pending</span>

<?php } ?>

</div>

</div>

<div class="invoice-actions">

<a class="btn btn-primary"
href="invoice_system/invoice/generate_invoice_pdf.php?invoice_id=<?php echo $id?>">

<i class="bi bi-download"></i> Download Invoice

</a>

<a class="btn btn-success"
href="teacher_dashboard.php?page=invoice_system/payments/record_payment.php?invoice_id=<?php echo $id?>">

<i class="bi bi-cash"></i> Record Payment

</a>

</div>

</div>

</div>


<style>

.invoice-view-page{
padding:10px;
}

.invoice-header{
margin-bottom:20px;
}

.invoice-header h3{
font-weight:600;
color:#05364d;
}

.invoice-card{
background:white;
padding:25px;
border-radius:15px;
box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.invoice-grid{
display:grid;
grid-template-columns:repeat(2,1fr);
gap:20px;
margin-bottom:20px;
}

.info-box label{
font-size:13px;
color:#777;
display:block;
}

.info-box p{
font-size:16px;
font-weight:600;
margin-top:5px;
}

.invoice-actions{
display:flex;
gap:10px;
}

</style>