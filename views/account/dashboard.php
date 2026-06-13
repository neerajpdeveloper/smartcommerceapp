<style>
.dashboard{
    display:flex;
    gap:20px;
    margin:30px auto;
    max-width:1200px;
}

.sidebar{
    width:250px;
    background:#fff;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
    overflow:hidden;
}

.sidebar a{
    display:block;
    padding:15px 20px;
    text-decoration:none;
    color:#333;
    border-bottom:1px solid #eee;
}

.sidebar a:hover,
.sidebar a.active{
    background:#000;
    color:#fff;
}

.content{
    flex:1;
}

.stats{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:15px;
    margin-bottom:20px;
}

.stat-card{
    background:#fff;
    padding:20px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

.stat-card h3{
    margin:0;
    font-size:30px;
}

.card{
    background:#fff;
    padding:20px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}
</style>

<div class="dashboard">

    <div class="sidebar">


        <a href="<?=siteUrl()?>/user/dashboard">
        Dashboard
    </a>

    <a href="<?=siteUrl()?>/user/orders">
        My Orders
    </a>

    <a href="<?=siteUrl()?>/user/addresses">
        My Addresses
    </a>

    <a href="<?=siteUrl()?>/user/profile">
        Profile
    </a>

    <a href="<?=siteUrl()?>/logout">
        Logout
    </a>
    </div>

    <div class="content">

        <h2>Welcome, <?= $user['name'] ?> 👋</h2>

        <div class="stats">

            <div class="stat-card">
                <h3><?= $totalOrders ?? 0 ?></h3>
                <p>Total Orders</p>
            </div>

            <div class="stat-card">
                <h3><?= $pendingOrders ?? 0 ?></h3>
                <p>Pending Orders</p>
            </div>

            <div class="stat-card">
                <h3><?= $totalAddresses ?? 0 ?></h3>
                <p>Addresses</p>
            </div>

                    <div class="stat-card">
                <h3><?= $cartItems ?></h3>
                <p>Cart Items</p>
            </div>

        </div>

        <div class="card">

            <h3>Account Information</h3>

            <p>
                <strong>Name:</strong>
                <?= $user['name'] ?>
            </p>

            <p>
                <strong>Email:</strong>
                <?= $user['email'] ?>
            </p>

        </div>

    </div>

</div>