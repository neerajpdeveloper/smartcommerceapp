<?php

$page_title = "Payment Gateways";

include '../includes/admin-header.php';

$db = (new Config())->db();

$gateways = $db->query("
    SELECT *
    FROM payment_gateways
    ORDER BY id DESC
")->fetchAll(PDO::FETCH_OBJ);

?>

<div class="content-wrapper">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h3>Payment Gateways</h3>

        <a href="create.php" class="btn btn-primary">
            + Add Gateway
        </a>

    </div>

    <?php adminflashMessage(); ?>

    <div class="card shadow-sm">

        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead class="table-dark">

                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Mode</th>
                        <th>Status</th>
                        <th width="150">Action</th>
                    </tr>

                </thead>

                <tbody>

                <?php foreach($gateways as $gateway){ ?>

                    <tr>

                        <td><?= $gateway->id ?></td>

                        <td><?= $gateway->name ?></td>

                        <td>
                            <span class="badge bg-info">
                                <?= strtoupper($gateway->code) ?>
                            </span>
                        </td>

                        <td>

                            <?php if($gateway->mode == 'live'){ ?>

                                <span class="badge bg-success">
                                    Live
                                </span>

                            <?php } else { ?>

                                <span class="badge bg-warning text-dark">
                                    Test
                                </span>

                            <?php } ?>

                        </td>

                        <td>

                            <?php if($gateway->status){ ?>

                                <span class="badge bg-success">
                                    Active
                                </span>

                            <?php } else { ?>

                                <span class="badge bg-danger">
                                    Inactive
                                </span>

                            <?php } ?>

                        </td>

                        <td>

                            <a href="edit.php?id=<?= $gateway->id ?>"
                               class="btn btn-sm btn-warning">

                                Edit

                            </a>

                            <a href="delete.php?id=<?= $gateway->id ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Delete this gateway?')">

                                Delete

                            </a>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include '../includes/footer.php'; ?>