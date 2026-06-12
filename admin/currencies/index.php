<?php
$page_title = "Currencies";
include '../includes/admin-header.php';

$db = (new Config())->db();

$currencies = $db->query("SELECT * FROM currencies ORDER BY id DESC")->fetchAll(PDO::FETCH_OBJ);
?>
<div class="content-wrapper">
<h3>Currencies</h3>

<a href="update-rates.php" class="btn btn-primary mb-3">
Update Currency Rates
</a>

<?php adminflashMessage(); ?>

<table class="table table-bordered">
<tr>
    <th>Code</th>
    <th>Name</th>
    <th>Symbol</th>
    <th>Rate (vs INR)</th>
    <th>Default</th>
</tr>

<?php foreach($currencies as $c){ ?>
<tr>
    <td><?= $c->code ?></td>
    <td><?= $c->name ?></td>
    <td><?= $c->symbol ?></td>
    <td><?= $c->rate ?></td>
    <td><?= $c->is_default ? 'Yes' : 'No' ?></td>
</tr>
<?php } ?>
</table>
</div>

<?php include '../includes/footer.php'; ?>