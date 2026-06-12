<?php
$page_title = "Add Coupon";
include '../includes/admin-header.php';

$db = (new Config())->db();
?>

<div class="content-wrapper">

<h3>Add Coupon</h3>

<form method="post" action="store.php">

<input type="text" name="code" class="form-control mb-2" placeholder="Coupon Code">

<select name="type" class="form-control mb-2">
    <option value="fixed">Fixed</option>
    <option value="percent">Percent</option>
</select>

<input type="number" name="value" class="form-control mb-2" placeholder="Value">

<input type="number" name="min_order_amount" class="form-control mb-2" placeholder="Min Order Amount">

<input type="number" name="usage_limit" class="form-control mb-2" placeholder="Usage Limit">

<input type="date" name="start_date" class="form-control mb-2">

<input type="date" name="end_date" class="form-control mb-2">

<button class="btn btn-success">Save Coupon</button>

</form>

</div>

<?php include '../includes/footer.php'; ?>