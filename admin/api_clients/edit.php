<?php

$page_title = "Edit API Client";
include '../includes/admin-header.php';

$db = (new Config())->db();

$stmt = $db->prepare("
    SELECT *
    FROM api_clients
    WHERE id = ?
");

$stmt->execute([
    $_GET['id']
]);

$client = $stmt->fetch(PDO::FETCH_OBJ);

?>

<div class="content-wrapper">

    <div class="page-header">

        <div>
            <h2>Edit API Client</h2>
            <p>Update API client information</p>
        </div>

        <a href="index.php" class="btn btn-secondary">
            ← Back
        </a>

    </div>

    <?php adminflashMessage(); ?>

    <div class="card">

        <div class="card-header">
            <h3>Client Details</h3>
        </div>

        <div class="card-body">

            <form action="update.php" method="POST">

                <input
                    type="hidden"
                    name="id"
                    value="<?= $client->id ?>">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Client Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="<?= htmlspecialchars($client->name) ?>"
                            required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Email Address
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="<?= htmlspecialchars($client->email) ?>"
                            required>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Company Name
                        </label>

                        <input
                            type="text"
                            name="company_name"
                            class="form-control"
                            value="<?= htmlspecialchars($client->company_name) ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Status
                        </label>

                        <select
                            name="status"
                            class="form-control">

                            <option
                                value="1"
                                <?= $client->status == 1 ? 'selected' : '' ?>>
                                Active
                            </option>

                            <option
                                value="0"
                                <?= $client->status == 0 ? 'selected' : '' ?>>
                                Inactive
                            </option>

                        </select>

                    </div>

                </div>

                <hr>

                <button
                    type="submit"
                    class="btn btn-primary">
                    Update Client
                </button>

                <a
                    href="index.php"
                    class="btn btn-secondary">
                    Cancel
                </a>

            </form>

        </div>

    </div>

</div>

<?php include '../includes/footer.php'; ?>