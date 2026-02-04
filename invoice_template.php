<?php
// Safety check (debug ke liye – production me hata sakte ho)
if (!isset($logoBase64)) {
    die("Logo base64 variable missing.");
}

$fullName = $student['first_name'] . ' ' . $student['last_name'];
$date     = date('F d, Y', strtotime($student['created_at']));
$course   = $student['course_title'];
$price    = $price;
$gst      = $gst;
$total    = $total;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Invoice</title>

<style>
@page { margin: 30px; }

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 13px;
    color: #333;
}

.invoice-wrapper {
    width: 100%;
}

/* Header */
.header-table {
    width: 100%;
    margin-bottom: 20px;
}
.header-table td {
    vertical-align: top;
}
.logo img {
    width: 140px;
}
.invoice-title {
    text-align: right;
}
.invoice-title h1 {
    margin: 0;
    font-size: 30px;
    letter-spacing: 1px;
}
.company-address {
    text-align: right;
    font-size: 12px;
    line-height: 18px;
}

/* Bill info */
.bill-table {
    width: 100%;
    margin-top: 20px;
}
.bill-table td {
    vertical-align: top;
    font-size: 13px;
}
.bill-to {
    width: 55%;
}
.invoice-meta {
    width: 45%;
}
.invoice-meta table {
    width: 100%;
}
.invoice-meta td {
    padding: 3px 0;
}
.highlight {
    background: #f3f3f3;
    font-weight: bold;
}

/* Items table */
.items-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
}
.items-table th {
    background: #3b3b3b;
    color: #fff;
    padding: 10px;
    text-align: left;
}
.items-table td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

/* Totals */
.totals-table {
    width: 100%;
    margin-top: 20px;
}
.totals-table td {
    padding: 6px;
}
.totals-label {
    text-align: right;
    width: 80%;
}
.total-amount {
    font-weight: bold;
    border-top: 2px solid #333;
}
.amount-due {
    background: #f3f3f3;
    font-weight: bold;
}

/* Notes */
.notes {
    margin-top: 40px;
    font-size: 12px;
    color: #555;
}
</style>
</head>

<body>
<div class="invoice-wrapper">

<!-- HEADER -->
<table class="header-table">
<tr>
    <td class="logo">
        <!-- ✅ FINAL FIXED LOGO (Base64 – Dompdf safe) -->
        <img src="<?php echo $logoBase64; ?>" alt="Logo">
    </td>
    <td class="invoice-title">
        <h1>INVOICE</h1>
        <div class="company-address">
            <strong>Achievers Castle Learning Centre Ltd.</strong><br>
            11-102 Cope Crescent<br>
            Saskatoon, Saskatchewan S7T 0C7<br>
            Canada<br><br>
            (639) 384-2844
        </div>
    </td>
</tr>
</table>

<hr>

<!-- BILLING -->
<table class="bill-table">
<tr>
    <td class="bill-to">
        <strong>BILL TO</strong><br><br>
        <?php echo $fullName; ?><br>
        <?php echo $student['email']; ?>
    </td>
    <td class="invoice-meta">
        <table>
            <tr>
                <td><strong>Invoice Number:</strong></td>
                <td>AC-<?php echo $student['id']; ?></td>
            </tr>
            <tr>
                <td><strong>Invoice Date:</strong></td>
                <td><?php echo $date; ?></td>
            </tr>
            <tr>
                <td><strong>Payment Due:</strong></td>
                <td><?php echo $date; ?></td>
            </tr>
            <tr class="highlight">
                <td>Amount Due (CAD):</td>
                <td>$<?php echo number_format($total, 2); ?></td>
            </tr>
        </table>
    </td>
</tr>
</table>

<!-- ITEMS -->
<table class="items-table">
<thead>
<tr>
    <th>Items</th>
    <th>Quantity</th>
    <th>Price</th>
    <th>Amount</th>
</tr>
</thead>
<tbody>
<tr>
    <td>
        <strong>Tuition Fees</strong><br>
        <?php echo $course; ?>
    </td>
    <td>1</td>
    <td>$<?php echo number_format($price, 2); ?></td>
    <td>$<?php echo number_format($price, 2); ?></td>
</tr>
</tbody>
</table>

<!-- TOTALS -->
<table class="totals-table">
<tr>
    <td class="totals-label">Subtotal:</td>
    <td>$<?php echo number_format($price, 2); ?></td>
</tr>
<tr>
    <td class="totals-label">GST 18%:</td>
    <td>$<?php echo number_format($gst, 2); ?></td>
</tr>
<tr class="total-amount">
    <td class="totals-label">Total:</td>
    <td>$<?php echo number_format($total, 2); ?></td>
</tr>
<tr class="amount-due">
    <td class="totals-label">Amount Due (CAD):</td>
    <td>$<?php echo number_format($total, 2); ?></td>
</tr>
</table>

<!-- NOTES -->
<div class="notes">
<strong>Notes / Terms</strong><br>
Make all cheques payable to Achievers Castle Learning Centre Ltd.<br>
Total due in 15 days. Overdue accounts subject to a service charge of 1% per month.
</div>

</div>
</body>
</html>
