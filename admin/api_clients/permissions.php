<?php

$page_title = "Assign Permissions";

include '../includes/admin-header.php';

$db = (new Config())->db();

$clientId = (int) ($_GET['id'] ?? 0);

if (!$clientId) {

    $_SESSION['error'] = 'Invalid Client';

    adminRedirect('api_clients/index.php');
}

$clientStmt = $db->prepare("
    SELECT *
    FROM api_clients
    WHERE id = ?
");

$clientStmt->execute([$clientId]);

$client = $clientStmt->fetch(PDO::FETCH_OBJ);

if (!$client) {

    $_SESSION['error'] = 'Client not found';

    adminRedirect('api_clients/index.php');
}

/*
|--------------------------------------------------------------------------
| All Permissions
|--------------------------------------------------------------------------
*/

$permissions = $db->query("
    SELECT *
    FROM api_permissions
    ORDER BY permission_key ASC
")->fetchAll(PDO::FETCH_OBJ);

/*
|--------------------------------------------------------------------------
| Assigned Permissions
|--------------------------------------------------------------------------
*/

$assigned = $db->prepare("
    SELECT permission_id
    FROM api_client_permissions
    WHERE client_id = ?
");

$assigned->execute([$clientId]);

$assignedPermissions = $assigned->fetchAll(PDO::FETCH_COLUMN);

?>

<div class="content-wrapper">

    <div class="page-header">
        <div>
            <h2>Assign Permissions</h2>
            <p class="text-muted">
                Manage API access for this client
            </p>
        </div>

        <a href="index.php" class="btn btn-secondary">
            ← Back
        </a>
    </div>

    <?php adminflashMessage(); ?>

    <form action="<?=adminUrl()?>api_clients/save_permissions.php" method="POST">

        <input
            type="hidden"
            name="client_id"
            value="<?= $client->id ?>">

        <!-- CLIENT CARD -->

        <div class="card shadow-sm mb-4">

            <div class="card-header">
                <h4>Client Details</h4>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Client Name
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="<?= htmlspecialchars($client->name) ?>"
                            readonly>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="<?= htmlspecialchars($client->email) ?>"
                            readonly>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Company
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="<?= htmlspecialchars($client->company_name) ?>"
                            readonly>
                    </div>

                </div>

            </div>

        </div>

        <!-- PERMISSION CARD -->

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h4 class="mb-0">
                    API Permissions
                </h4>

                <div>

                    <button
                        type="button"
                        class="btn btn-success btn-sm"
                        onclick="selectAllPermissions()">
                        Select All
                    </button>

                    <button
                        type="button"
                        class="btn btn-danger btn-sm"
                        onclick="unselectAllPermissions()">
                        Unselect All
                    </button>

                </div>

            </div>

            <div class="card-body">

                <div class="row">

                    <?php foreach($permissions as $permission): ?>

                        <div class="col-md-4 mb-3">

                            <div class="border rounded p-3 h-100">

                                <div class="form-check">

                                    <input
                                        class="form-check-input permission-checkbox"
                                        type="checkbox"
                                        name="permissions[]"
                                        value="<?= $permission->id ?>"
                                        id="permission<?= $permission->id ?>"

                                        <?= in_array(
                                            $permission->id,
                                            $assignedPermissions
                                        ) ? 'checked' : '' ?>

                                    >

                                    <label
                                        class="form-check-label fw-bold"
                                        for="permission<?= $permission->id ?>">

                                        <?= htmlspecialchars(
                                            $permission->permission_key
                                        ) ?>

                                    </label>

                                </div>

                                <div class="small text-muted mt-2">

                                    <?= htmlspecialchars(
                                        $permission->description
                                    ) ?>

                                </div>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

            </div>

            <div class="card-footer text-end">

                <button
                    type="submit"
                    class="btn btn-primary">

                    Save Permissions

                </button>

            </div>

        </div>

    </form>

</div>

<script>

function selectAllPermissions()
{
    document.querySelectorAll(
        '.permission-checkbox'
    ).forEach(function(item){

        item.checked = true;

    });
}

function unselectAllPermissions()
{
    document.querySelectorAll(
        '.permission-checkbox'
    ).forEach(function(item){

        item.checked = false;

    });
}

</script>

<?php include '../includes/footer.php'; ?>