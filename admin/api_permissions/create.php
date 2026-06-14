<?php

$page_title = "Create Permission";

include '../includes/admin-header.php';

?>

<div class="content-wrapper">

<form action="store.php" method="POST">

<div class="card">

<div class="card-header">
    <h3>Create Permission</h3>
</div>

<div class="card-body">

<div class="mb-3">
<label>Permission Key</label>

<input
type="text"
name="permission_key"
class="form-control"
placeholder="products.read">
</div>

<div class="mb-3">
<label>Description</label>

<textarea
name="description"
class="form-control"></textarea>
</div>

</div>

<div class="card-footer">

<button class="btn btn-primary">
Save Permission
</button>

</div>

</div>

</form>

</div>

<?php include '../includes/footer.php'; ?>