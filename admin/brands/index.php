<?php
$page_title = "Brands";
include '../includes/admin-header.php';

$db = (new Config())->db();
$brands = $db->query("SELECT * FROM brands ORDER BY id DESC")->fetchAll(PDO::FETCH_OBJ);
?>

<div class="content-wrapper">

<h3>brands</h3>

<a href="create.php" class="btn btn-primary mb-3">+ Add brands</a>
<?php adminflashMessage(); ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($brands as $cat){ ?>
        <tr>
            <td><?= $cat->id ?></td>
            <td><?= $cat->name ?></td>
            <td><?= $cat->slug ?></td>
            <td>
                <?= $cat->status ? 'Active' : 'Inactive' ?>
            </td>
            <td>
                <a href="edit.php?id=<?= $cat->id ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="delete.php?id=<?= $cat->id ?>" class="btn btn-sm btn-danger"
                   onclick="return confirm('Delete this brands?')">
                   Delete
                </a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

</div>

<?php include '../includes/footer.php'; ?>