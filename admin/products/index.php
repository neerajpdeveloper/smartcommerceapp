<?php
$page_title = "Products";
include '../includes/admin-header.php';

$db = (new Config())->db();
$products = $db->query("
SELECT p.*, c.name AS category, b.name AS brand
FROM products p
LEFT JOIN categories c ON c.id = p.category_id
LEFT JOIN brands b ON b.id = p.brand_id
ORDER BY p.id DESC
")->fetchAll(PDO::FETCH_OBJ);
?>

<div class="content-wrapper">

<h3>Products</h3>

<a href="create.php" class="btn btn-primary mb-3">+ Add Products</a>
<?php adminflashMessage(); ?>
<table class="table table-bordered">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Category</th>
    <th>Brand</th>
    <th>Price</th>
    <th>Stock</th>
    <th>Action</th>
</tr>

<?php foreach($products as $p){ ?>
<tr>
    <td><?= $p->id ?></td>
    <td><?= $p->name ?></td>
    <td><?= $p->category ?></td>
    <td><?= $p->brand ?></td>
    <td><?= $p->price ?></td>
    <td><?= $p->stock ?></td>
    <td>
        <a href="edit.php?id=<?= $p->id ?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="delete.php?id=<?= $p->id ?>" class="btn btn-danger btn-sm"
           onclick="return confirm('Delete product?')">Delete</a>
    </td>
</tr>
<?php } ?>
</table>

</div>

<?php include '../includes/footer.php'; ?>