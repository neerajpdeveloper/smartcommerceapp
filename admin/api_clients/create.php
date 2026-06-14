<?php
$page_title = "Create API Client";
include '../includes/admin-header.php';
?>

<div class="content-wrapper">

<div class="card">

<h3>Create API Client</h3>

<form action="store.php" method="post">

<div class="mb-3">
<label>Name</label>
<input
type="text"
name="name"
class="form-control"
required>
</div>

<div class="mb-3">
<label>Email</label>
<input
type="email"
name="email"
class="form-control"
required>
</div>

<div class="mb-3">
<label>Company</label>
<input
type="text"
name="company_name"
class="form-control">
</div>

<div class="mb-3">
<label>Status</label>

<select
name="status"
class="form-control">

<option value="1">Active</option>
<option value="0">Inactive</option>

</select>

</div>

<button class="btn btn-primary">
Save Client
</button>

</form>

</div>

</div>

<?php include '../includes/footer.php'; ?>