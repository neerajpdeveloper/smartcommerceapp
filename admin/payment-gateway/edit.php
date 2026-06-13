<?php

$page_title = "Edit Payment Gateway";

include __DIR__.'/../includes/admin-header.php';

$db = (new Config())->db();

$id = (int)($_GET['id'] ?? 0);

$stmt = $db->prepare("
    SELECT *
    FROM payment_gateways
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$id]);

$gateway = $stmt->fetch(PDO::FETCH_OBJ);

if(!$gateway){
    $_SESSION['error'] = 'Gateway not found';
    adminRedirect('payment-gateways');
    exit;
}
?>

<div class="content-wrapper">

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h3 class="mb-0">
                Edit Payment Gateway
            </h3>

            <a href="index.php"
               class="btn btn-secondary">
                Back
            </a>

        </div>

        <div class="card-body">

            <?php adminflashMessage(); ?>

            <form method="POST" action="update.php">

                <input type="hidden"
                       name="id"
                       value="<?= $gateway->id ?>">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Gateway Name
                        </label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               value="<?= htmlspecialchars($gateway->name) ?>"
                               required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Gateway Code
                        </label>

                        <input type="text"
                               name="code"
                               class="form-control"
                               value="<?= htmlspecialchars($gateway->code) ?>"
                               readonly>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Mode
                        </label>

                        <select name="mode"
                                class="form-select">

                            <option value="test"
                                <?= $gateway->mode == 'test' ? 'selected' : '' ?>>
                                Test
                            </option>

                            <option value="live"
                                <?= $gateway->mode == 'live' ? 'selected' : '' ?>>
                                Live
                            </option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status"
                                class="form-select">

                            <option value="1"
                                <?= $gateway->status ? 'selected' : '' ?>>
                                Active
                            </option>

                            <option value="0"
                                <?= !$gateway->status ? 'selected' : '' ?>>
                                Inactive
                            </option>

                        </select>

                    </div>

                </div>

               <div class="mb-3">

                    <label class="form-label">
                        API Url
                    </label>
                        <input type="text"
                           name="api_url"
                           class="form-control"
                           value="<?= htmlspecialchars($gateway->api_url) ?>">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Client ID / Publish Key
                    </label>

                    <textarea
                        name="client_id"
                        rows="4"
                        class="form-control"><?= htmlspecialchars($gateway->client_id) ?></textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Secret Key
                    </label>

                    <textarea
                        name="secret_key"
                        rows="4"
                        class="form-control"><?= htmlspecialchars($gateway->secret_key) ?></textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Extra Key
                    </label>

                    <input type="text"
                           name="extra_key"
                           class="form-control"
                           value="<?= htmlspecialchars($gateway->extra_key) ?>">

                </div>

                <button type="submit"
                        class="btn btn-primary">

                    Update Gateway

                </button>

            </form>

        </div>

    </div>

</div>

<?php include __DIR__.'/../includes/footer.php'; ?>