<aside class="sidebar">

<ul>

<li>
<a href="../dashboard/">
<i class="fas fa-home"></i>
Dashboard
</a>
</li>

<li>
<a href="<?=adminUrl()?>products/">
<i class="fas fa-box"></i>
Products
</a>
</li>

<li>
<a href="<?=adminUrl()?>categories/">
<i class="fas fa-list"></i>
Categories
</a>
</li>
<li>
<a href="<?=adminUrl()?>brands/">
<i class="fas fa-list"></i>
Brands
</a>
</li>
<li>
<a href="<?=adminUrl()?>coupons/">
<i class="fas fa-list"></i>
Coupons
</a>
</li>
<li>
<a href="<?=adminUrl()?>currencies/">
<i class="fas fa-list"></i>
Currencies
</a>
</li>
<li>
<a href="#">
<i class="fas fa-shopping-cart"></i>
Orders
</a>
</li>

<li>
<a href="#">
<i class="fas fa-credit-card"></i>
Payments
</a>
</li>

<li>
<a href="#">
<i class="fas fa-users"></i>
Customers
</a>
</li>

<!-- SETTINGS DROPDOWN -->
<li class="has-submenu">
<a href="javascript:void(0)">
<i class="fas fa-cog"></i>
Settings
</a>

<ul class="submenu">

<li>
    <a href="<?=adminUrl('api_clients')?>">
        API Clients
    </a>
</li>

<li>
    <a href="<?=adminUrl('api_permissions')?>">
        API Permissions
    </a>
</li>


<li>
    <a href="<?=adminUrl('api_logs')?>">
        API Logs
    </a>
</li>
    <li>
        <a href="<?=adminUrl()?>payment-gateway">
            <i class="fas fa-user"></i> Payment Gateway
        </a>
    </li>
    <li>
        <a href="<?=adminUrl()?>profile.php">
            <i class="fas fa-user"></i> Profile
        </a>
    </li>

    <li>
        <a href="<?=adminUrl()?>change-password.php">
            <i class="fas fa-lock"></i> Change Password
        </a>
    </li>
</ul>

</li>

</ul>

</aside>