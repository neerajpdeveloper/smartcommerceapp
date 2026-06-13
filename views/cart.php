<h2>Shopping Cart</h2>

<?php if(!empty($cartItems)){ ?>

<style>
.cart-table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
}

.cart-table th,
.cart-table td{
    padding:15px;
    border-bottom:1px solid #eee;
    text-align:center;
}

.qty-box{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
}

.qty-btn{
    width:35px;
    height:35px;
    border:none;
    background:#000;
    color:#fff;
    cursor:pointer;
    border-radius:5px;
    font-size:18px;
}

.qty-input{
    width:50px;
    text-align:center;
    border:1px solid #ddd;
    padding:6px;
}

.remove-btn{
    color:red;
    text-decoration:none;
}
</style>

<table class="cart-table">

    <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Total</th>
        <th>Action</th>
    </tr>

    <?php foreach($cartItems as $item){ ?>

    <tr>

        <td>
            <a href="<?= siteUrl() ?>/product/<?= $item->slug ?>">
                <?= $item->name ?>
            </a>
        </td>

        <td>
            <?= price($item->price) ?>
        </td>

        <td>

            <div class="qty-box">

                <button
                    class="qty-btn"
                    onclick="updateQty(<?= $item->id ?>,'minus')">
                    -
                </button>

                <input
                    type="text"
                    class="qty-input"
                    value="<?= $item->qty ?>"
                    readonly>

                <button
                    class="qty-btn"
                    onclick="updateQty(<?= $item->id ?>,'plus')">
                    +
                </button>

            </div>

        </td>

        <td>
            <?= price($item->price * $item->qty) ?>
        </td>

        <td>
            <a class="remove-btn"
               href="<?= siteUrl() ?>/cart-remove/<?= $item->id ?>">
                Remove
            </a>
        </td>

    </tr>

    <?php } ?>

</table>

<div style="margin-top:20px;text-align:right;">

    <h3>
        Grand Total:
        <?= price($cartTotal) ?>
    </h3>

    <a href="<?= siteUrl() ?>/checkout"
       style="
       background:#000;
       color:#fff;
       padding:12px 20px;
       text-decoration:none;
       border-radius:6px;">
       Proceed To Checkout
    </a>

</div>

<?php } else { ?>

<div style="text-align:center;padding:50px;">
    <h3>Your cart is empty</h3>

    <a href="<?= siteUrl() ?>">
        Continue Shopping
    </a>
</div>

<?php } ?>

<script>
function updateQty(cartId,type)
{
    fetch("<?= siteUrl() ?>/cart-update", {

        method:"POST",

        headers:{
            "Content-Type":"application/x-www-form-urlencoded"
        },

        body:"cart_id="+cartId+"&type="+type

    })
    .then(res => res.json())
    .then(data => {

        if(data.status){
            location.reload();
        }else{
            alert(data.message);
        }

    });
}
</script>