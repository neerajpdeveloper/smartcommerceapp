<?php
$page_title = "API Clients";
include '../includes/admin-header.php';

$db = (new Config())->db();

$clients = $db
->query("
SELECT *
FROM api_clients
ORDER BY id DESC
")
->fetchAll(PDO::FETCH_OBJ);
?>

<div class="content-wrapper">

<div class="page-header">
    <h2>API Clients</h2>
    <a href="create.php" class="btn btn-primary">
        + Add Client
    </a>
</div>

<?php adminflashMessage(); ?>

<div class="card">
<table class="table table-hover">

<thead>
<tr>
    <th>ID</th>
    <th>Client</th>
    <th>Email</th>
    <th>Company</th>
    <th>Status</th>
    <th>Created</th>
    <th width="350">Actions</th>
</tr>
</thead>

<tbody>

<?php foreach($clients as $client): ?>

<tr>

<td><?= $client->id ?></td>

<td><?= $client->name ?></td>

<td><?= $client->email ?></td>

<td><?= $client->company_name ?></td>

<td>
<?php if($client->status): ?>
<span class="badge bg-success">Active</span>
<?php else: ?>
<span class="badge bg-danger">Inactive</span>
<?php endif; ?>
</td>

<td>
<?= date('d M Y',strtotime($client->created_at)) ?>
</td>

<td>

<a
href="edit.php?id=<?= $client->id ?>"
class="btn btn-warning btn-sm">
Edit
</a>

<a
href="permissions.php?id=<?= $client->id ?>"
class="btn btn-info btn-sm">
Permissions
</a>

<a
href="tokens.php?id=<?= $client->id ?>"
class="btn btn-success btn-sm">
Tokens
</a>

<a
href="delete.php?id=<?= $client->id ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete Client?')">
Delete
</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>
</div>

</div>

<?php include '../includes/footer.php'; ?>