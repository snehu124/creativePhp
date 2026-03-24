<?php
include "../../db_config.php";

$id = $_GET['invoice_id'] ?? 0;

if($_SERVER['REQUEST_METHOD']=="POST"){

$invoice_id = (int)$_POST['invoice_id'];
$amount = $_POST['amount'];
$method = $_POST['method'];

mysqli_query($conn,"
INSERT INTO payments
(invoice_id,amount,payment_method,payment_date)
VALUES
('$invoice_id','$amount','$method',CURDATE())
");

mysqli_query($conn,"
UPDATE invoices
SET status='Paid'
WHERE id='$invoice_id'
");

echo "<script>
alert('Payment Recorded Successfully');
window.location='teacher_dashboard.php?page=invoice_system/invoice/invoice_list.php';

</script>";

exit;
}
?>

<div class="payment-page">

<div class="payment-header">
<h3><i class="bi bi-cash"></i> Record Payment</h3>
</div>

<div class="payment-card">

<form id="paymentForm">

<input type="hidden" name="invoice_id" value="<?php echo $id; ?>">

<div class="form-group">

<label>Amount</label>

<input
class="form-control"
name="amount"
value="<?php

$inv = mysqli_fetch_assoc(mysqli_query($conn,"SELECT total FROM invoices WHERE id='$id'"));
echo $inv['total'];

?>"
required>

</div>

<div class="form-group">

<label>Payment Method</label>

<select class="form-control" name="method" required>

<option value="">Select Method</option>
<option>Cash</option>
<option>Bank Transfer</option>
<option>E-transfer</option>

</select>

</div>

<button class="btn btn-success" name="pay">

<i class="bi bi-check-circle"></i> Record Payment

</button>

</form>

<script>

$("#paymentForm").submit(function(e){

e.preventDefault();

let formData=$(this).serialize();

$.ajax({

url:"invoice_system/payments/record_payment.php?invoice_id=<?php echo $id; ?>",
type:"POST",
data:formData,

success:function(res){

$("#content-area").html(res);

},

error:function(){

alert("Payment failed");

}

});

});

</script>

</div>

</div>

<style>

.payment-page{
padding:10px;
}

.payment-header{
margin-bottom:20px;
}

.payment-header h3{
font-weight:600;
color:#05364d;
}

.payment-card{
background:white;
padding:25px;
border-radius:15px;
box-shadow:0 5px 15px rgba(0,0,0,0.05);
max-width:400px;
}

.form-group{
margin-bottom:15px;
}

.form-group label{
font-size:14px;
font-weight:500;
}

.form-control{
padding:10px;
border-radius:8px;
border:1px solid #ddd;
width:100%;
}

</style>