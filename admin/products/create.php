<?php
$page_title = "Products";
include '../includes/admin-header.php';

$db = (new Config())->db();

$categories = $db->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_OBJ);
$brands = $db->query("SELECT * FROM brands")->fetchAll(PDO::FETCH_OBJ);
?>
<div class="content-wrapper">
<h3>Add Product</h3>

<form method="post" action="store.php">

<input type="text" name="name" class="form-control mb-2" placeholder="Product Name">

<select name="category_id" class="form-control mb-2">
<option value="">Select Category</option>
<?php foreach($categories as $c){ ?>
<option value="<?= $c->id ?>"><?= $c->name ?></option>
<?php } ?>
</select>

<select name="brand_id" class="form-control mb-2">
<option value="">Select Brand</option>
<?php foreach($brands as $b){ ?>
<option value="<?= $b->id ?>"><?= $b->name ?></option>
<?php } ?>
</select>

<input type="number" name="price" class="form-control mb-2" placeholder="Price">

<input type="number" name="stock" class="form-control mb-2" placeholder="Stock">

<textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>

<button class="btn btn-success">Save Product</button>

</form>

</div>