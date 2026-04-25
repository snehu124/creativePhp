<?php
include "../../../db_config.php";

$result=mysqli_query($conn,"
SELECT 
    payments.*, 
    enrollment_inquiries.first_name,

    CASE 
        WHEN sph.status = 'Expired' THEN 'Expired'
        WHEN sph.status = 'Active' THEN 'Active'
        WHEN enrollment_inquiries.status = 'Cancelled' THEN 'Cancelled'
        ELSE 'Active'
    END AS enroll_status

FROM payments
LEFT JOIN invoices 
    ON payments.invoice_id = invoices.id

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

ORDER BY payments.id DESC
");

?>
<link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">
<div class="payment-page">

<div class="page-header">

<h2>
<i class="bi bi-cash-coin"></i>
Payments
</h2>

</div>

<div class="payment-card">

<table class="table table-hover align-middle">

<thead style="text-align:center;">

<tr>
<th>Sr No</th>
<th>Student</th>
<th>Amount</th>
<th>Method</th>
<th>Date</th>
<th>Receipt</th>
<th> Enrollment Status</th>
</tr>

</thead>

<tbody style="text-align:center;">

<?php 
$sr = 1;

if(mysqli_num_rows($result) == 0){ 
?>

<tr>
<td colspan="7" style="text-align:center;">
    No payment records found
</td>
</tr>

<?php } else { ?>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><b><?php echo $sr++; ?></b></td>

<td><?php echo $row['first_name']?></td>

<td>$<?php echo $row['amount']?></td>

<td>
<span class="badge bg-info text-dark">
<?php echo $row['payment_method']?>
</span>
</td>

<td><?php echo $row['payment_date']?></td>

<td>
<a class="btn btn-sm btn-primary"
href="invoice_system/payments/generate_receipt_pdf.php?payment_id=<?php echo $row['id']?>"
target="_blank">
<i class="bi bi-file-earmark-pdf"></i>
Receipt
</a>
</td>

<td>
<?php 
$status = strtolower($row['enroll_status']);

if($status == "cancelled"){
    echo '<span class="badge bg-danger">Cancelled</span>';
}
elseif($status == "expired"){
    echo '<span class="badge bg-secondary">Expired</span>';
}
elseif($status == "active"){
    echo '<span class="badge bg-success">Active</span>';
}
else{
    echo '<span class="badge bg-dark">Unknown</span>';
}
?>
</td>

</tr>

<?php } } ?>

</tbody>

</div>

</div>


<style>

.page-header{
margin-bottom:20px;
}

.page-header h2{
font-family:"Love Ya Like A Sister", cursive;
font-size:30px;
color:#05364d;
margin-bottom:30px;
}

.payment-card{
background:white;
padding:20px;
border-radius:15px;
box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.btn-primary{
  background: linear-gradient(160deg, #1e3a8a, #2563eb);
  color: white;
  box-shadow: 8px 0 15px rgba(0,0,0,0.35);
  border-radius: 20px;
  padding: 6px 14px;


}
/* ================= MOBILE RESPONSIVE ================= */

@media (max-width:768px){

  /* 🔥 table scrollable banao */
  .payment-card{
    overflow-x:auto;
  }

  table{
    min-width:650px; /* horizontal scroll enable */
  }

  /* header font */
  .page-header h2{
    font-size:30px;
  }

  /* table compact */
  .table th,
  .table td{
    padding:10px 8px;
    font-size:13px;
    white-space:nowrap;
  }

  /* badge compact */
  .badge{
    font-size:11px;
    padding:5px 8px;
  }

  /* button compact */
  .btn{
    font-size:12px;
    padding:5px 10px;
  }

}
</style>