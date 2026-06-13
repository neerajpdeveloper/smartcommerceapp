
<style>

.success-wrapper{
    max-width:900px;
    margin:50px auto;
    padding:20px;
}

.success-card{
    background:#fff;
    border-radius:20px;
    padding:50px;
    text-align:center;
    box-shadow:0 10px 40px rgba(0,0,0,.08);
    border:1px solid #eee;
}

.success-icon{
    width:100px;
    height:100px;
    margin:auto;
    border-radius:50%;
    background:#dcfce7;
    color:#16a34a;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:50px;
    margin-bottom:25px;
}

.success-title{
    font-size:34px;
    font-weight:700;
    margin-bottom:10px;
    color:#111;
}

.success-subtitle{
    color:#666;
    font-size:16px;
    margin-bottom:35px;
}

.order-box{
    background:#f9fafb;
    border-radius:16px;
    padding:25px;
    text-align:left;
    margin-top:20px;
}

.order-row{
    display:flex;
    justify-content:space-between;
    padding:12px 0;
    border-bottom:1px solid #ececec;
}

.order-row:last-child{
    border-bottom:none;
}

.order-label{
    color:#666;
    font-weight:500;
}

.order-value{
    font-weight:700;
    color:#111;
}

.status-badge{
    background:#fef3c7;
    color:#92400e;
    padding:6px 14px;
    border-radius:30px;
    font-size:13px;
    font-weight:600;
}

.success-actions{
    margin-top:35px;
    display:flex;
    justify-content:center;
    gap:15px;
    flex-wrap:wrap;
}

.btn-primary{
    background:#000;
    color:#fff;
    padding:14px 28px;
    border-radius:12px;
    text-decoration:none;
    font-weight:600;
    transition:.3s;
}

.btn-primary:hover{
    background:#222;
}

.btn-secondary{
    background:#f3f4f6;
    color:#111;
    padding:14px 28px;
    border-radius:12px;
    text-decoration:none;
    font-weight:600;
}

.btn-secondary:hover{
    background:#e5e7eb;
}

.thankyou-note{
    margin-top:30px;
    color:#666;
    font-size:15px;
    line-height:1.7;
}

@media(max-width:768px){

    .success-card{
        padding:30px 20px;
    }

    .success-title{
        font-size:26px;
    }

    .order-row{
        flex-direction:column;
        gap:5px;
    }

}
</style>

<div class="success-wrapper">

    <div class="success-card">

        <div class="success-icon">
            ✓
        </div>

        <div class="success-title">
            Order Placed Successfully
        </div>

        <div class="success-subtitle">
            Thank you for shopping with us.
            Your order has been received and is being processed.
        </div>

        <div class="order-box">

            <div class="order-row">

                <div class="order-label">
                    Order Number
                </div>

                <div class="order-value">
                    <?= $order->order_no ?>
                </div>

            </div>

            <div class="order-row">

                <div class="order-label">
                    Payment Method
                </div>

                <div class="order-value">
                    <?= strtoupper($order->payment_method) ?>
                </div>

            </div>

            <div class="order-row">

                <div class="order-label">
                    Payment Status
                </div>

                <div class="order-value">

                    <?php if($order->payment_status == 'paid'){ ?>

                        <span class="status-badge"
                              style="background:#dcfce7;color:#166534;">
                            Paid
                        </span>

                    <?php } else { ?>

                        <span class="status-badge">
                            Pending
                        </span>

                    <?php } ?>

                </div>

            </div>

            <div class="order-row">

                <div class="order-label">
                    Order Status
                </div>

                <div class="order-value">
                    <?= ucfirst($order->order_status) ?>
                </div>

            </div>

            <div class="order-row">

                <div class="order-label">
                    Grand Total
                </div>

                <div class="order-value">
                    <?= price($order->grand_total) ?>
                </div>

            </div>

            <div class="order-row">

                <div class="order-label">
                    Order Date
                </div>

                <div class="order-value">
                    <?= date('d M Y h:i A', strtotime($order->created_at)) ?>
                </div>

            </div>

        </div>

        <div class="success-actions">

            <a href="<?= siteUrl() ?>/user/orders"
               class="btn-primary">

                My Orders

            </a>

            <a href="<?= siteUrl() ?>"
               class="btn-secondary">

                Continue Shopping

            </a>

        </div>

        <div class="thankyou-note">

            A confirmation email will be sent shortly.
            You can track your order anytime from
            your account dashboard.

        </div>

    </div>

</div>
