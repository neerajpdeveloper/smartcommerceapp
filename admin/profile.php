<?php

$page_title = 'My Profile';
include __DIR__.'/includes/admin-header.php';

?>

<div class="content-wrapper py-4">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">My Profile</h3>
            <small class="text-muted">Manage your account information</small>
        </div>
    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <!-- PROFILE HEADER -->
            <div class="d-flex align-items-center mb-4">

                <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center"
                     style="width:70px;height:70px;font-size:28px;">
                    <i class="fas fa-user"></i>
                </div>

                <div class="ms-3">
                    <h5 class="mb-0"><?= $_SESSION['admin_name']; ?></h5>
                    <small class="text-muted"><?= $_SESSION['admin_email']; ?></small>
                    <div class="mt-1">
                        <span class="badge bg-success">
                            <?= $_SESSION['admin_role']; ?>
                        </span>
                    </div>
                </div>

            </div>

            <!-- ALERTS -->
            <?php adminflashMessage(); ?>

            <!-- FORM -->
            <form method="post" action="update-profile.php">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control"
                               value="<?= $_SESSION['admin_name']; ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control"
                               value="<?= $_SESSION['admin_email']; ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Role</label>
                        <input type="text" class="form-control"
                               value="<?= $_SESSION['admin_role']; ?>" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <input type="text" class="form-control" value="Active" readonly>
                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

<?php include __DIR__.'/includes/footer.php'; ?>