<style>
.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
    flex-wrap:wrap;
    gap:15px;
}

.page-header h2{
    font-size:30px;
    font-weight:700;
    color:#222;
    margin:0;
}

.btn-add{
    background:#000;
    color:#fff;
    padding:12px 22px;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
    transition:.3s;
}

.btn-add:hover{
    background:#222;
}

.address-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(350px,1fr));
    gap:20px;
}

.address-card{
    position:relative;
    background:#fff;
    border-radius:16px;
    padding:25px;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
    transition:.3s;
    border:1px solid #eee;
}

.address-card:hover{
    transform:translateY(-4px);
    box-shadow:0 10px 30px rgba(0,0,0,.12);
}

.default-badge{
    position:absolute;
    top:15px;
    right:15px;
    background:#16a34a;
    color:#fff;
    padding:5px 12px;
    border-radius:30px;
    font-size:12px;
    font-weight:600;
}

.address-name{
    font-size:20px;
    font-weight:700;
    color:#222;
    margin-bottom:10px;
}

.address-mobile{
    color:#555;
    margin-bottom:12px;
    font-size:15px;
}

.address-text{
    color:#666;
    line-height:1.7;
    margin-bottom:20px;
}

.address-actions{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.action-btn{
    padding:8px 15px;
    border-radius:8px;
    text-decoration:none;
    font-size:14px;
    font-weight:600;
    transition:.3s;
}

.edit-btn{
    background:#f3f4f6;
    color:#111;
}

.edit-btn:hover{
    background:#e5e7eb;
}

.delete-btn{
    background:#fee2e2;
    color:#dc2626;
}

.delete-btn:hover{
    background:#fecaca;
}

.default-btn{
    background:#dcfce7;
    color:#16a34a;
}

.default-btn:hover{
    background:#bbf7d0;
}

.empty-address{
    background:#fff;
    border-radius:15px;
    padding:60px 20px;
    text-align:center;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

.empty-address h3{
    margin-bottom:10px;
}

@media(max-width:768px){

    .page-header{
        flex-direction:column;
        align-items:flex-start;
    }

    .address-grid{
        grid-template-columns:1fr;
    }
}
</style>

<div class="page-header">

    <h2>My Addresses</h2>

    <a href="<?= siteUrl() ?>/user/address-add"
       class="btn-add">
        + Add New Address
    </a>

</div>

<?php if(!empty($addresses)){ ?>

<div class="address-grid">

<?php foreach($addresses as $item){ ?>

    <div class="address-card">

        <?php if($item->is_default){ ?>

            <span class="default-badge">
                Default Address
            </span>

        <?php } ?>

        <div class="address-name">
            <?= $item->full_name ?>
        </div>

        <div class="address-mobile">
            📞 <?= $item->mobile ?>
        </div>

        <div class="address-text">

            <?= $item->address_line ?>

            <br><br>

            <strong>
                <?= $item->city ?>
            </strong>

            ,

            <?= $item->state ?>

            -

            <?= $item->pincode ?>

        </div>

        <div class="address-actions">

            <a href="<?= siteUrl() ?>/user/address-edit/<?= $item->id ?>"
               class="action-btn edit-btn">
                Edit
            </a>

            <a href="<?= siteUrl() ?>/user/address-delete/<?= $item->id ?>"
               onclick="return confirm('Delete this address?')"
               class="action-btn delete-btn">
                Delete
            </a>

            <?php if(!$item->is_default){ ?>

                <a href="<?= siteUrl() ?>/user/address-default/<?= $item->id ?>"
                   class="action-btn default-btn">
                    Make Default
                </a>

            <?php } ?>

        </div>

    </div>

<?php } ?>

</div>

<?php } else { ?>

<div class="empty-address">

    <h3>No Address Found</h3>

    <p>
        Add your first delivery address to continue shopping.
    </p>

    <br>

    <a href="<?= siteUrl() ?>/user/address-add"
       class="btn-add">
        Add Address
    </a>

</div>

<?php } ?>