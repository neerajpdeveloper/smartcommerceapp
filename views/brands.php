<h1>Brands</h1>

<?php foreach($brands as $brand){ ?>

    <div>
        <a href="<?=siteUrl()?>/brands/<?= $brand->slug ?>">
            <?= $brand->name ?> (<?= $brand->total_products ?>)
        </a>
    </div>

<?php } ?>