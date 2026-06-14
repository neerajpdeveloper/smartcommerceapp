<?php

$page_title = "API Logs";

include '../includes/admin-header.php';

$db = (new Config())->db();

$stmt = $db->query("
SELECT
    l.*,
    c.name,
    c.company_name
FROM api_logs l
LEFT JOIN api_clients c
ON c.id = l.client_id
ORDER BY l.id DESC
LIMIT 500
");

$logs = $stmt->fetchAll(PDO::FETCH_OBJ);

?>

<div class="content-wrapper">

    <div class="page-header">

        <div>
            <h2>API Logs</h2>
            <p class="text-muted">
                Monitor all API requests and responses
            </p>
        </div>

    </div>

    <?php adminflashMessage(); ?>

    <div class="card">

        <div class="card-header">
            <h4>Request Logs</h4>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead>

                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Endpoint</th>
                        <th>Method</th>
                        <th>IP Address</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>

                    </thead>

                    <tbody>

                    <?php if($logs): ?>

                        <?php foreach($logs as $log): ?>

                            <tr>

                                <td>
                                    #<?= $log->id ?>
                                </td>

                                <td>

                                    <strong>
                                        <?= htmlspecialchars($log->name ?? 'N/A') ?>
                                    </strong>

                                    <br>

                                    <small class="text-muted">
                                        <?= htmlspecialchars($log->company_name ?? '') ?>
                                    </small>

                                </td>

                                <td>

                                    <code>
                                        <?= htmlspecialchars($log->endpoint) ?>
                                    </code>

                                </td>

                                <td>

                                    <?php if($log->method == 'GET'): ?>

                                        <span class="badge bg-success">
                                            GET
                                        </span>

                                    <?php elseif($log->method == 'POST'): ?>

                                        <span class="badge bg-primary">
                                            POST
                                        </span>

                                    <?php elseif($log->method == 'PUT'): ?>

                                        <span class="badge bg-warning">
                                            PUT
                                        </span>

                                    <?php elseif($log->method == 'DELETE'): ?>

                                        <span class="badge bg-danger">
                                            DELETE
                                        </span>

                                    <?php else: ?>

                                        <?= $log->method ?>

                                    <?php endif; ?>

                                </td>

                                <td>
                                    <?= $log->ip_address ?>
                                </td>

                                <td>

                                    <?php if($log->response_code == 200): ?>

                                        <span class="badge bg-success">
                                            200
                                        </span>

                                    <?php elseif($log->response_code == 401): ?>

                                        <span class="badge bg-danger">
                                            401
                                        </span>

                                    <?php elseif($log->response_code == 403): ?>

                                        <span class="badge bg-warning">
                                            403
                                        </span>

                                    <?php else: ?>

                                        <span class="badge bg-secondary">
                                            <?= $log->response_code ?>
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>

                                    <?= date(
                                        'd M Y h:i A',
                                        strtotime($log->created_at)
                                    ) ?>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="7" class="text-center py-5">
                                No API Logs Found
                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<?php include '../includes/footer.php'; ?>