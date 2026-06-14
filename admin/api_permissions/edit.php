<?php

$page_title = "Edit Permission";

include '../includes/admin-header.php';

$db = (new Config())->db();

$stmt = $db->prepare("
SELECT *
FROM api_permissions
WHERE id=?
");

$stmt->execute([
$_GET['id']
]);

$permission =
$stmt->fetch(PDO::FETCH_OBJ);

?>

<div class="content-wrapper">

<form action="update.php" method="POST">

<input
type="hidden"
name="id"
value="<?= $permission->id ?>">

<div class="card">

<div class="card-header">
    <h3>Edit Permission</h3>
</div>

<div class="card-body">

<div class="mb-3">

<label>Permission Key</label>

<input
type="text"
name="permission_key"
value="<?= $permission->permission_key ?>"
class="form-control">

</div>

<div class="mb-3">

<label>Description</label>

<textarea
name="description"
class="form-control"><?= $permission->description ?></textarea>

</div>

</div>

<div class="card-footer">

<button class="btn btn-primary">
Update Permission
</button>

</div>

</div>

</form>

</div>