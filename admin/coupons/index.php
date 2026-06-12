<?php
$page_title = "Coupons";
include '../includes/admin-header.php';

$db = (new Config())->db();

$coupons = $db->query("SELECT * FROM coupons ORDER BY id DESC")->fetchAll(PDO::FETCH_OBJ);
?>
<div class="content-wrapper">
<h3>Coupons</h3>

<a href="create.php" class="btn btn-primary mb-3">+ Add Coupon</a>

<?php adminflashMessage(); ?>

<table class="table table-bordered">
<tr>
    <th>ID</th>
    <th>Code</th>
    <th>Type</th>
    <th>Value</th>
    <th>Limit</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php foreach($coupons as $c){ ?>
<tr>
    <td><?= $c->id ?></td>
    <td><?= $c->code ?></td>
    <td><?= $c->type ?></td>
    <td><?= $c->value ?></td>
    <td><?= $c->usage_limit ?></td>
    <td><?= $c->status ? 'Active' : 'Inactive' ?></td>
    <td>
        <a href="edit.php?id=<?= $c->id ?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="delete.php?id=<?= $c->id ?>" class="btn btn-danger btn-sm"
           onclick="return confirm('Delete coupon?')">Delete</a>
    </td>
</tr>
<?php } ?>
</table>

</div>