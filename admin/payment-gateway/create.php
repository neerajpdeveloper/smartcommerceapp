<?php

$page_title = "Add Payment Gateway";

include '../includes/admin-header.php';

?>

<div class="content-wrapper">

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h3 class="mb-0">Add Payment Gateway</h3>

            <a href="index.php" class="btn btn-secondary">
                Back
            </a>

        </div>

        <div class="card-body">

            <?php adminflashMessage(); ?>

            <form method="POST" action="store.php">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Gateway Name
                        </label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="PayPal"
                               required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Gateway Code
                        </label>

                        <input type="text"
                               name="code"
                               class="form-control"
                               placeholder="paypal"
                               required>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Mode
                        </label>

                        <select name="mode"
                                class="form-select">

                            <option value="test">
                                Test
                            </option>

                            <option value="live">
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

                            <option value="1">
                                Active
                            </option>

                            <option value="0">
                                Inactive
                            </option>

                        </select>

                    </div>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        API Url
                    </label>

                    <textarea
                        name="api_url"
                        class="form-control"
                        rows="4"
                        placeholder="Enter API Url"></textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Client ID / Publish Key
                    </label>

                    <textarea
                        name="client_id"
                        class="form-control"
                        rows="4"
                        placeholder="Enter Client ID"></textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Secret Key
                    </label>

                    <textarea
                        name="secret_key"
                        class="form-control"
                        rows="4"
                        placeholder="Enter Secret Key"></textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Extra Key (Optional)
                    </label>

                    <input type="text"
                           name="extra_key"
                           class="form-control"
                           placeholder="Webhook Secret / Merchant ID">

                </div>

                <div class="text-end">

                    <button type="submit"
                            class="btn btn-success">

                        Save Gateway

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php include '../includes/footer.php'; ?>