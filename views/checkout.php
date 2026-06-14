<?php flashMessage()?>
<style>
.checkout-page{
    max-width:1400px;
    margin:30px auto;
}

.checkout-grid{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:25px;
}

.checkout-card{
    background:#fff;
    border-radius:16px;
    padding:25px;
    margin-bottom:20px;
    box-shadow:0 5px 20px rgba(0,0,0,.06);
    border:1px solid #eee;
}

.checkout-title{
    font-size:22px;
    font-weight:700;
    margin-bottom:20px;
    color:#222;
}

.address-option{
    border:2px solid #eee;
    border-radius:14px;
    padding:18px;
    margin-bottom:15px;
    cursor:pointer;
    transition:.3s;
    display:block;
}

.address-option:hover{
    border-color:#000;
}

.address-option input{
    margin-right:10px;
}

.address-name{
    font-size:16px;
    font-weight:700;
    margin-bottom:5px;
}

.address-phone{
    color:#555;
    margin-bottom:8px;
}

.address-text{
    color:#666;
    line-height:1.6;
}

.default-badge{
    background:#16a34a;
    color:#fff;
    padding:4px 10px;
    border-radius:20px;
    font-size:12px;
    margin-left:10px;
}

.payment-option{
    border:2px solid #eee;
    border-radius:12px;
    padding:15px;
    margin-bottom:12px;
    cursor:pointer;
    transition:.3s;
}

.payment-option:hover{
    border-color:#000;
}

.summary-item{
    display:flex;
    justify-content:space-between;
    margin-bottom:12px;
    font-size:14px;
}

.summary-total{
    display:flex;
    justify-content:space-between;
    font-size:22px;
    font-weight:700;
    margin-top:20px;
}

.checkout-btn{
    width:100%;
    border:none;
    background:#000;
    color:#fff;
    padding:16px;
    border-radius:12px;
    font-size:17px;
    font-weight:600;
    cursor:pointer;
    margin-top:20px;
}

.checkout-btn:hover{
    background:#222;
}

.secure-text{
    text-align:center;
    font-size:13px;
    color:#666;
    margin-top:15px;
}

.add-address-btn{
    display:inline-block;
    margin-bottom:20px;
    background:#f3f4f6;
    color:#111;
    padding:10px 16px;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
}

@media(max-width:992px){

    .checkout-grid{
        grid-template-columns:1fr;
    }

}

.payment-methods{
    display:flex;
    flex-direction:column;
    gap:15px;
}

.payment-option{
    border:2px solid #ececec;
    border-radius:14px;
    padding:18px;
    cursor:pointer;
    transition:.3s;
    display:block;
    position:relative;
}

.payment-option:hover{
    border-color:#000;
    background:#fafafa;
}

.payment-option input[type="radio"]{
    position:absolute;
    right:20px;
    top:24px;
    transform:scale(1.2);
}

.payment-content{
    display:flex;
    align-items:center;
    gap:15px;
}

.payment-icon{
    width:55px;
    height:55px;
    border-radius:12px;
    background:#f5f5f5;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
}

.payment-name{
    font-size:16px;
    font-weight:700;
    color:#222;
}

.payment-desc{
    color:#666;
    font-size:13px;
    margin-top:4px;
}
</style>

<form method="POST"
      action="<?= siteUrl() ?>/place-order">

<div class="checkout-page">

    <div class="checkout-grid">

        <!-- LEFT SIDE -->

        <div>

            <!-- ADDRESS -->

            <div class="checkout-card">

                <div class="checkout-title">
                    Delivery Address
                </div>

                <a href="<?= siteUrl() ?>/user/address-add"
                   class="add-address-btn">
                    + Add New Address
                </a>

                <?php foreach($addresses as $address){ ?>

                <label class="address-option">

                    <input
                        type="radio"
                        name="address_id"
                        value="<?= $address->id ?>"
                        <?= $address->is_default ? 'checked' : '' ?>
                        required>

                    <span class="address-name">

                        <?= $address->full_name ?>

                        <?php if($address->is_default){ ?>

                            <span class="default-badge">
                                Default
                            </span>

                        <?php } ?>

                    </span>

                    <div class="address-phone">
                        <?= $address->mobile ?>
                    </div>

                    <div class="address-text">

                        <?= $address->address_line ?>

                        <br>

                        <?= $address->city ?>,
                        <?= $address->state ?> -
                        <?= $address->pincode ?>

                    </div>

                </label>

                <?php } ?>

            </div>

            <!-- PAYMENT -->

           <?php

$db = (new Config())->db();

$stmt = $db->query("
    SELECT *
    FROM payment_gateways
    WHERE status = 1
    ORDER BY orderby ASC
");

$gateways = $stmt->fetchAll(PDO::FETCH_OBJ);

?>

<div class="checkout-card">

    <div class="checkout-title">
        Payment Method
    </div>

    <div class="payment-methods">

        <?php foreach($gateways as $gateway){ ?>

            <?php

            $icon = '💳';
            $description = 'Secure Payment';

            switch($gateway->code){

                case 'razorpay':
                    $icon = '🇮🇳';
                    $description = 'UPI, Cards, Net Banking, Wallet';
                break;

                case 'paypal':
                    $icon = '🌍';
                    $description = 'International Payments';
                break;

                case 'stripe':
                    $icon = '💳';
                    $description = 'Cards & Global Payments';
                break;

                case 'cod':
                    $icon = '📦';
                    $description = 'Pay When Product Arrives';
                break;
            }

            ?>

            <label class="payment-option">

                <input type="radio"
                       name="payment_method"
                       value="<?= $gateway->code ?>"
                       required>

                <div class="payment-content">

                    <div class="payment-icon">
                        <?= $icon ?>
                    </div>

                    <div>

                        <div class="payment-name">
                            <?= $gateway->name ?>
                        </div>

                        <div class="payment-desc">
                            <?= $description ?>
                        </div>

                    </div>

                </div>

            </label>


        <?php } ?>

    </div>

</div>

        </div>

        <!-- RIGHT SIDE -->

        <div>

            <div class="checkout-card">

                <div class="checkout-title">
                    Order Summary
                </div>

                <?php foreach($cartItems as $item){ ?>

                <div class="summary-item">

                    <span>

                        <?= $item->name ?>

                        ×

                        <?= $item->qty ?>

                    </span>

                    <span>

                        <?= price(
                            $item->price * $item->qty
                        ) ?>

                    </span>

                </div>

                <?php } ?>

                <hr>

                <div class="summary-item">

                    <span>Subtotal</span>

                    <span>
                        <?= price($cartTotal) ?>
                    </span>

                </div>

                <div class="summary-item">

                    <span>Shipping</span>

                    <span>Free</span>

                </div>

                <div class="summary-total">

                    <span>Total</span>

                    <span>
                        <?= price($cartTotal) ?>
                    </span>

                </div>

                <button type="submit"
                        class="checkout-btn">

                    Place Order

                </button>

                <div class="secure-text">

                    🔒 Secure Checkout

                    <br>

                    Multi Currency &
                    Multiple Payment Gateway Supported

                </div>

            </div>

        </div>

    </div>

</div>

</form>