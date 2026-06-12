<h1>Categories</h1>

<?php foreach($categories as $cat){ ?>

    <div>
        <a href="<?=siteUrl()?>/category/<?= $cat->slug ?>">
            <?= $cat->name ?> (<?= $cat->total_products ?>)
        </a>
    </div>

<?php } ?>