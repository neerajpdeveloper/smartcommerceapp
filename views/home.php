<?php
// data comes from controller:
// $featured, $new, $categories
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>

    <style>
        body{
            font-family: Arial;
            margin: 0;
            background: #f5f5f5;
        }

        .container{
            width: 1200px;
            margin: auto;
        }

        /* HEADER */
        .header{
            background: #111;
            color: #fff;
            padding: 15px;
        }

        .header h2{
            margin: 0;
        }

        /* SECTION TITLE */
        .title{
            margin: 20px 0;
            font-size: 22px;
            font-weight: bold;
        }

        /* GRID */
        .grid{
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        /* CARD */
        .card{
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
            transition: 0.3s;
        }

        .card:hover{
            transform: translateY(-5px);
        }

        .card h3{
            font-size: 16px;
            margin: 10px 0;
        }

        .price{
            color: green;
            font-weight: bold;
        }

        /* CATEGORY */
        .category{
            display: inline-block;
            background: #fff;
            padding: 10px 15px;
            margin: 5px;
            border-radius: 20px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
        }

        /* BUTTON */
        .btn{
            display: inline-block;
            padding: 6px 10px;
            background: #000;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }

    </style>
</head>

<body>

<div class="header">
    <div class="container">
        <h2>My Shop</h2>
    </div>
</div>

<div class="container">

    <!-- CATEGORIES -->
    <div class="title">Categories</div>

    <?php foreach($categories as $cat){ ?>
        <div class="category">
            <a class="btn" href="<?=siteUrl()?>/category/<?= $cat->slug ?>">
                   <?= $cat->name ?>
                </a>
        </div>
    <?php } ?>

    <!-- FEATURED -->
    <div class="title">Featured Products</div>

    <div class="grid">
        <?php foreach($featured as $p){ ?>
            <div class="card">
                <h3><?= $p->name ?></h3>
                <div class="price">₹<?= $p->price ?></div>

                <a class="btn" href="/product/<?= $p->slug ?>">
                    View
                </a>
            </div>
        <?php } ?>
    </div>

    <!-- NEW ARRIVALS -->
    <div class="title">New Arrivals</div>

    <div class="grid">
        <?php foreach($new as $p){ ?>
            <div class="card">
                <h3><?= $p->name ?></h3>
                <div class="price">₹<?= $p->price ?></div>

                <a class="btn" href="/product/<?= $p->slug ?>">
                    View
                </a>
            </div>
        <?php } ?>
    </div>

</div>

</body>
</html>