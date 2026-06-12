<?php
$page_title = "Products";
include '../includes/admin-header.php';
$db = (new Config())->db();

$id = $_GET['id'];

$product = $db->prepare("SELECT * FROM products WHERE id = ?");
$product->execute([$id]);
$product = $product->fetch(PDO::FETCH_OBJ);

$categories = $db->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_OBJ);
$brands = $db->query("SELECT * FROM brands")->fetchAll(PDO::FETCH_OBJ);
?>
<div class="content-wrapper">
<h3>Edit Product</h3>

<form method="post" action="update.php">

<input type="hidden" name="id" value="<?= $product->id ?>">

<input type="text" name="name" value="<?= $product->name ?>" class="form-control mb-2">

<select name="category_id" class="form-control mb-2">
<?php foreach($categories as $c){ ?>
<option value="<?= $c->id ?>" <?= $product->category_id==$c->id?'selected':'' ?>>
<?= $c->name ?>
</option>
<?php } ?>
</select>

<select name="brand_id" class="form-control mb-2">
<?php foreach($brands as $b){ ?>
<option value="<?= $b->id ?>" <?= $product->brand_id==$b->id?'selected':'' ?>>
<?= $b->name ?>
</option>
<?php } ?>
</select>

<input type="number" name="price" value="<?= $product->price ?>" class="form-control mb-2">

<input type="number" name="stock" value="<?= $product->stock ?>" class="form-control mb-2">

<textarea name="description" class="form-control mb-2"><?= $product->description ?></textarea>

<button class="btn btn-primary">Update</button>

</form>

</div>