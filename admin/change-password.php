<?php
$page_title = 'Change Password';
include __DIR__.'/includes/admin-header.php';
?>

<style>
.password-wrapper {
    min-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.password-card {
    width: 100%;
    max-width: 520px;
    border-radius: 16px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    overflow: hidden;
}

.password-card .card-header {
    background: linear-gradient(135deg, #4f46e5, #3b82f6);
    color: #fff;
    padding: 20px;
    text-align: center;
}

.password-card .card-body {
    padding: 30px;
}

.form-control {
    border-radius: 10px;
    padding: 10px 14px;
}

.btn-primary {
    border-radius: 10px;
    padding: 10px;
    font-weight: 600;
}

.alert {
    border-radius: 10px;
}
</style>

<div class="content-wrapper py-4">

    <div class="password-wrapper">

        <div class="card password-card">

            <!-- HEADER -->
            <div class="card-header">
                <h4 class="mb-0">🔒 Change Password</h4>
                <small>Secure your account</small>
            </div>

            <div class="card-body">

                <!-- ALERT -->
               <?php adminflashMessage(); ?>

                <!-- FORM -->
                <form method="post" action="updatepassword.php">

                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control" placeholder="Enter current password" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control" placeholder="Enter new password" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm new password" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        🔐 Update Password
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<?php include __DIR__.'/includes/footer.php'; ?>