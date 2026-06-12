<?php
$page_title = "Edit Coupon";
include __DIR__.'/../includes/admin-header.php';

$db = (new Config())->db();

$id = $_GET['id'];

$stmt = $db->prepare("SELECT * FROM coupons WHERE id = ?");
$stmt->execute([$id]);
$coupon = $stmt->fetch(PDO::FETCH_OBJ);
?>

<div class="content-wrapper">

<h3>Edit Coupon</h3>

<form method="post" action="update.php">

<input type="hidden" name="id" value="<?= $coupon->id ?>">

<input type="text" name="code" value="<?= $coupon->code ?>" class="form-control mb-2">

<select name="type" class="form-control mb-2">
    <option value="fixed" <?= $coupon->type=='fixed'?'selected':'' ?>>Fixed</option>
    <option value="percent" <?= $coupon->type=='percent'?'selected':'' ?>>Percent</option>
</select>

<input type="number" name="value" value="<?= $coupon->value ?>" class="form-control mb-2">

<input type="number" name="min_order_amount" value="<?= $coupon->min_order_amount ?>" class="form-control mb-2">

<button class="btn btn-primary">Update</button>

</form>

</div>

<?php include __DIR__.'/../includes/footer.php'; ?>