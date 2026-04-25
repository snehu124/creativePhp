<?php
include "../../../db_config.php";

$id = $_GET['id'] ?? 0;

if(!$id){
    die("Invalid Invoice ID");
}

$data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT 
    invoices.*, 
    invoices.status AS payment_status,
    enrollment_inquiries.*, 
    payments.id AS payment_id,

    CASE 
        WHEN sph.status = 'Expired' THEN 'Expired'
        WHEN sph.status = 'Active' THEN 'Active'
        WHEN enrollment_inquiries.status = 'Cancelled' THEN 'Cancelled'
        ELSE 'Active'
    END AS enroll_status

FROM invoices

LEFT JOIN enrollment_inquiries
ON invoices.student_id = enrollment_inquiries.student_id

LEFT JOIN (
    SELECT sph1.*
    FROM student_plan_history sph1
    INNER JOIN (
        SELECT invoice_id, MAX(id) as max_id
        FROM student_plan_history
        GROUP BY invoice_id
    ) sph2 
    ON sph1.id = sph2.max_id
) sph 
ON invoices.id = sph.invoice_id

LEFT JOIN payments
ON payments.invoice_id = invoices.id

WHERE invoices.id='$id'
"));

if(!$data){
    die("Invoice not found or relation broken");
}

$invoice = [
    "original_price" => $data['price'] + $data['discount_amount'], 
    "discount_type" => $data['discount_type'],
    "discount_amount" => $data['discount_amount'],
    "price_after_discount" => $data['price'],
    "gst" => $data['gst'],
    "total" => $data['total']
];

$discount_description = $data['discount_description'] ?? '';
?>
<link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">

<div class="invoice-view-page">

<div class="invoice-header">
<h3><i class="bi bi-receipt-cutoff"></i> Invoice Details</h3>
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

<!-- PAYMENT STATUS -->
<div class="info-box">
<label>Payment Status</label>

<?php if($data['payment_status']=="Paid"){ ?>
<span class="badge bg-success">Paid</span>
<?php } else { ?>
<span class="badge bg-warning text-dark">Pending</span>
<?php } ?>

</div>

<!-- ENROLLMENT STATUS -->
<div class="info-box">
<label>Enrollment Status</label>

<?php 
$status = strtolower($data['enroll_status']);

if($status == "cancelled"){
    echo '<span class="badge bg-danger">Cancelled</span>';
}
elseif($status == "expired"){
    echo '<span class="badge bg-secondary">Expired</span>';
}
else{
    echo '<span class="badge bg-success">Active</span>';
}
?>


</div>

</div>

<div class="invoice-actions">

<!-- DOWNLOAD -->
<a class="btn btn-primary"
href="invoice_system/invoice/generate_invoice_pdf.php?invoice_id=<?php echo $id?>">
<i class="bi bi-download"></i> Invoice
</a>

<?php 
$enroll = strtolower($data['enroll_status']);
$payment = strtolower($data['payment_status']);
?>

<!-- PAYMENT BUTTON LOGIC -->
<?php if($payment == "paid"){ ?>

    <a class="btn btn-success disabled-btn" href="javascript:void(0)">
        <i class="bi bi-wallet2"></i> Paid
    </a>

    <!-- SHOW RECEIPT ONLY IF PAID -->
    <a class="btn btn-primary"
    href="invoice_system/payments/generate_receipt_pdf.php?payment_id=<?php echo $data['payment_id']?>" target="_blank">
    <i class="bi bi-file-earmark-pdf"></i> Receipt
    </a>

<?php } elseif($enroll == "cancelled"){ ?>

    <a class="btn btn-success disabled-btn" href="javascript:void(0)">
        <i class="bi bi-x-circle"></i> Cancelled
    </a>

<?php } elseif($enroll == "expired"){ ?>

    <a class="btn btn-success disabled-btn" href="javascript:void(0)">
        <i class="bi bi-clock"></i> Expired
    </a>

<?php } else { ?>

    <a href="#"
       class="btn btn-success menu-link"
       data-page="invoice_system/payments/record_payment.php?invoice_id=<?php echo $id?>">
       <i class="bi bi-wallet2"></i> Pay
    </a>

<?php } ?>


<!-- CANCEL BUTTON -->
<?php if($enroll == "cancelled"){ ?>

<a class="btn btn-danger disabled-btn" href="javascript:void(0)">
<i class="bi bi-x-circle"></i> Cancelled
</a>

<?php } else { ?>

<a href="#"
   class="btn btn-danger menu-link"
   data-page="invoice_system/invoice/cancel_enrollment.php?id=<?php echo $data['id']; ?>">
   <i class="bi bi-x-circle"></i> Cancel Enrollment
</a>

<?php } ?>

</div>

</div>

</div>

<style>

.invoice-actions .btn{
  border-radius:25px;
}

.invoice-header{
margin-bottom:20px;
}

.invoice-header h3{
font-family:"Love Ya Like A Sister", cursive;
font-size:30px;
color:#05364d;
margin-bottom:30px;
}

.invoice-card{
background:white;
padding:25px;
border-radius:15px;
box-shadow:0 5px 15px rgba(0,0,0,0.05);
width:495px;
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
gap:7px;
margin-top: 40px;
}

.btn-primary{
  background: linear-gradient(160deg, #1e3a8a, #2563eb);
  color: white;
  box-shadow: 8px 0 15px rgba(0,0,0,0.35);
}

.btn-danger{
  background: linear-gradient(90deg, #ef4444, #dc2626);
  color: white;
  box-shadow: 0 5px 15px rgba(239,68,68,0.45);
}

  .disabled-btn{
  pointer-events: none;
  opacity: 0.6;
  cursor: not-allowed;
}

/* MOBILE */
@media (max-width:768px){

  .invoice-card{
    padding:18px;
    width:100%;
  }

  .invoice-grid{
    grid-template-columns:1fr;
    gap:15px;
  }

  .info-box p{
    font-size:15px;
  }

  .invoice-actions{
    flex-direction:column;
    gap:10px;
  }

  .invoice-actions .btn{
    width:100%;
    justify-content:center;
    font-size:14px;
    padding:10px;
  }

  .invoice-header h3{
    font-size:20px;
  }
}
</style>