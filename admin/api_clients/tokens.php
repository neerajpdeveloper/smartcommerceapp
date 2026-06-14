<?php

$page_title = "API Tokens";

include '../includes/admin-header.php';

$db = (new Config())->db();

$clientId = (int) ($_GET['id'] ?? 0);

if (!$clientId) {

    $_SESSION['error'] = 'Invalid Client';

    adminRedirect('api_clients/index.php');
}

$stmt = $db->prepare("
    SELECT *
    FROM api_clients
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$clientId]);

$client = $stmt->fetch(PDO::FETCH_OBJ);

if (!$client) {

    $_SESSION['error'] = 'Client not found';

    adminRedirect('api_clients/index.php');
}

$tokens = $db->prepare("
    SELECT *
    FROM api_tokens
    WHERE client_id = ?
    ORDER BY id DESC
");

$tokens->execute([$clientId]);

$tokens = $tokens->fetchAll(PDO::FETCH_OBJ);

?>

<div class="content-wrapper">

    <div class="page-header">

        <div>
            <h2>API Tokens</h2>
            <p class="text-muted">
                Manage access tokens for API Client
            </p>
        </div>

        <div>

            <a href="index.php"
               class="btn btn-secondary">
                Back
            </a>

            <a href="generate_token.php?id=<?= $client->id ?>"
               class="btn btn-primary">
                + Generate Token
            </a>

        </div>

    </div>

    <?php adminflashMessage(); ?>

    <!-- CLIENT INFO -->

    <div class="card mb-4">

        <div class="card-header">
            <h4>Client Details</h4>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4">
                    <strong>Name</strong><br>
                    <?= htmlspecialchars($client->name) ?>
                </div>

                <div class="col-md-4">
                    <strong>Email</strong><br>
                    <?= htmlspecialchars($client->email) ?>
                </div>

                <div class="col-md-4">
                    <strong>Company</strong><br>
                    <?= htmlspecialchars($client->company_name) ?>
                </div>

            </div>

        </div>

    </div>

    <!-- TOKEN LIST -->

    <div class="card">

        <div class="card-header">
            <h4>Generated Tokens</h4>
        </div>

        <div class="card-body p-0">

            <table class="table table-hover mb-0">

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Token</th>
                        <th>Status</th>
                        <th>Expires</th>
                        <th>Last Used</th>
                        <th>Created</th>
                        <th width="150">Action</th>
                    </tr>

                </thead>

                <tbody>

                <?php if(!empty($tokens)): ?>

                    <?php foreach($tokens as $token): ?>

                        <tr>

                            <td>
                                <?= $token->id ?>
                            </td>

                            <td>

                                <code style="font-size:12px;">
                                    <?= substr(
                                        $token->access_token,
                                        0,
                                        40
                                    ) ?>...
                                </code>

                            </td>

                            <td>

                                <?php if($token->status): ?>

                                    <span class="badge bg-success">
                                        Active
                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-danger">
                                        Revoked
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>

                                <?= $token->expires_at
                                    ? date(
                                        'd M Y',
                                        strtotime($token->expires_at)
                                    )
                                    : '-' ?>

                            </td>

                            <td>

                                <?= $token->last_used_at
                                    ? date(
                                        'd M Y H:i',
                                        strtotime($token->last_used_at)
                                    )
                                    : 'Never' ?>

                            </td>

                            <td>

                                <?= date(
                                    'd M Y',
                                    strtotime($token->created_at)
                                ) ?>

                            </td>

                            <td>

                                <?php if($token->status): ?>

                                    <a href="revoke_token.php?id=<?= $token->id ?>&client_id=<?= $client->id ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Revoke this token?')">

                                        Revoke

                                    </a>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="7"
                            class="text-center py-4">

                            No Tokens Generated

                        </td>

                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include '../includes/footer.php'; ?>