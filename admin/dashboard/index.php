<?php
$page_title = 'Dashboard';
include '../includes/admin-header.php';
?>
<div class="content-wrapper">

    <div class="page-header">
        <h2>Dashboard</h2>
        <p>Welcome Back, <?= $_SESSION['admin_name']; ?></p>
    </div>

    <div class="dashboard-cards">

        <div class="stat-card">
            <div class="icon bg-primary">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h3>125</h3>
            <p>Total Orders</p>
        </div>

        <div class="stat-card">
            <div class="icon bg-success">
                <i class="fas fa-rupee-sign"></i>
            </div>
            <h3>₹45,800</h3>
            <p>Total Sales</p>
        </div>

        <div class="stat-card">
            <div class="icon bg-warning">
                <i class="fas fa-box"></i>
            </div>
            <h3>540</h3>
            <p>Products</p>
        </div>

        <div class="stat-card">
            <div class="icon bg-danger">
                <i class="fas fa-users"></i>
            </div>
            <h3>82</h3>
            <p>Customers</p>
        </div>

    </div>

</div>

<?php include '../includes/footer.php'; ?>