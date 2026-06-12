<?php
$page_title = "Add Category";
include '../includes/admin-header.php';

$db = (new Config())->db();
?>

<div class="content-wrapper">

<h3>Add Category</h3>
<?php adminflashMessage(); ?>
<form method="post" action="store.php">

<div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" class="form-control" required>
</div>

<button class="btn btn-success">Save</button>

</form>

</div>

<?php include '../includes/footer.php'; ?>