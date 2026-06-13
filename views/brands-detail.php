<h1 style="margin:20px 0;">
    <?= $brands->name ?>
</h1>

<style>
    .product-grid{
        display:grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap:20px;
    }

    .product-card{
        background:#fff;
        border-radius:12px;
        padding:15px;
        box-shadow:0 2px 10px rgba(0,0,0,0.08);
        transition:0.3s;
        position:relative;
        overflow:hidden;
    }

    .product-card:hover{
        transform:translateY(-5px);
        box-shadow:0 6px 20px rgba(0,0,0,0.15);
    }

    .product-title{
        font-size:16px;
        font-weight:600;
        margin:10px 0 5px;
        color:#333;
        text-decoration:none;
        display:block;
    }

    .product-title:hover{
        color:#000;
    }

    .brand{
        font-size:12px;
        color:#777;
        margin-bottom:5px;
    }

    .price{
        font-size:18px;
        font-weight:bold;
        color:green;
        margin-top:8px;
    }

    .btn{
        display:inline-block;
        margin-top:10px;
        padding:6px 10px;
        background:#000;
        color:#fff;
        border-radius:6px;
        text-decoration:none;
        font-size:13px;
    }

    .btn:hover{
        background:#333;
    }
</style>

<div class="product-grid">

<?php foreach($products as $p){ ?>

    <div class="product-card">

        <!-- BRAND -->
        <div class="brand">
            <?= $p->cat_name ?? 'No Brand' ?>
        </div>

        <!-- PRODUCT NAME -->
        <a class="product-title"
           href="<?= siteUrl() ?>/product/<?= $p->slug ?>">
            <?= $p->name ?>
        </a>

        <!-- PRICE -->
        <div class="price">
            <?= price($p->price) ?>
        </div>

        <!-- BUTTON -->
        <a class="btn" href="<?= siteUrl() ?>/product/<?= $p->slug ?>">
            View Product
        </a>

    </div>

<?php } ?>

</div>