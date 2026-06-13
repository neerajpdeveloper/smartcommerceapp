<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: #f4f6f9;
        margin: 0;
        padding: 20px;
    }

    .container {
        max-width: 900px;
        margin: auto;
    }

    .card {
        background: #ffffff;
        border-radius: 14px;
        padding: 18px 20px;
        margin-bottom: 18px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.06);
        transition: 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    h3 {
        margin: 0 0 15px;
        font-size: 18px;
        color: #111;
        border-left: 4px solid #4f46e5;
        padding-left: 10px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .info-box {
        background: #f8fafc;
        padding: 10px 12px;
        border-radius: 10px;
        font-size: 14px;
        color: #333;
    }

    .item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }

    .item:last-child {
        border-bottom: none;
    }

    .item-name {
        font-weight: 600;
        font-size: 15px;
        color: #111;
    }

    .item small {
        display: block;
        margin-top: 3px;
        color: #777;
        font-size: 12px;
        line-height: 1.5;
    }

    .price {
        font-weight: 700;
        color: #16a34a;
        font-size: 15px;
    }

    .summary {
        text-align: right;
        font-size: 18px;
        font-weight: 700;
        margin-top: 10px;
        color: #111;
    }

    .summary span {
        color: #16a34a;
    }

    .currency-badge {
        display: inline-block;
        padding: 4px 10px;
        background: #eef2ff;
        color: #4f46e5;
        border-radius: 20px;
        font-size: 12px;
        margin-left: 6px;
    }
</style>

<div class="container">

    <!-- ORDER SUMMARY CARD -->
    <div class="card">
        <h3>Order Summary</h3>

        <div class="info-grid">

            <div class="info-box">
                <strong>Order No</strong><br>
                <?= $order['order_no'] ?>
            </div>

            <div class="info-box">
                <strong>Status</strong><br>
                <?= ucfirst($order['status']) ?>
            </div>

            <div class="info-box">
                <strong>Date</strong><br>
                <?= $order['created_at'] ?>
            </div>

            <div class="info-box">
                <strong>Payment Method</strong><br>
                <?= ucfirst($order['payment']['method']) ?>
            </div>

            <div class="info-box">
                <strong>Payment Status</strong><br>
                <?= ucfirst($order['payment']['status']) ?>
            </div>

            <div class="info-box">
                <strong>Transaction ID</strong><br>
                <?= $order['payment']['transaction_id'] ?: 'N/A' ?>
            </div>

        </div>
    </div>

    <!-- CURRENCY CARD -->
    <div class="card">
        <h3>Currency Details</h3>

        <div class="info-grid">

            <div class="info-box">
                <strong>Currency</strong><br>
                <?= $order['currency']['code'] ?>
                <span class="currency-badge">
                    <?= $order['currency']['symbol'] ?>
                </span>
            </div>

            <div class="info-box">
                <strong>Exchange Rate</strong><br>
                <?= $order['currency']['rate'] ?>
            </div>

        </div>
    </div>

    <!-- ITEMS CARD -->
    <div class="card">
        <h3>Products</h3>

        <?php $convertedTotal = 0; ?>

        <?php foreach ($order['items'] as $item): ?>

            <?php
                $convertedPrice = $item['price'] * $order['currency']['rate'];
                $convertedItemTotal = $item['total'] * $order['currency']['rate'];
                $convertedTotal += $convertedItemTotal;
            ?>

            <div class="item">
                <div>
                    <div class="item-name">
                        <?= $item['product_name'] ?>
                    </div>

                    <small>
                        SKU: <?= $item['sku'] ?> |
                        Product ID: <?= $item['product_id'] ?> <br>
                        Qty: <?= $item['qty'] ?> × 
                        <?= $order['currency']['symbol'] ?>
                        <?= number_format($convertedPrice, 2) ?> <br>
                        Base Price: <?= number_format($item['price'], 2) ?>
                    </small>
                </div>

                <div class="price">
                    <?= $order['currency']['symbol'] ?>
                    <?= number_format($convertedItemTotal, 2) ?>
                </div>
            </div>

        <?php endforeach; ?>

        <div class="summary">
            Grand Total:
            <span>
                <?= $order['currency']['symbol'] ?>
                <?= number_format($convertedTotal, 2) ?>
            </span>
            <small><?= strtolower($order['currency']['code']) ?></small>
        </div>

    </div>

</div>