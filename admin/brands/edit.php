<?php
$page_title = "Edit Brands";
include __DIR__.'/../includes/admin-header.php';

$db = (new Config())->db();

$id = $_GET['id'];
$stmt = $db->prepare("SELECT * FROM brands WHERE id = ?");
$stmt->execute([$id]);
$cat = $stmt->fetch(PDO::FETCH_OBJ);
?>

<div class="content-wrapper">

<h3>Edit Brands</h3>
<?php adminflashMessage(); ?>
<form method="post" action="update.php">

<input type="hidden" name="id" value="<?= $cat->id ?>">

<div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" value="<?= $cat->name ?>" class="form-control" required>
</div>

<button class="btn btn-primary">Update</button>

</form>

</div>

<?php include __DIR__.'/../includes/footer.php'; ?>