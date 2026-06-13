

<style>
.order-card {
    border: 1px solid #eee;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 20px;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.badge {
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 12px;
}

.processing { background: #17a2b8; color: #fff; }
.pending { background: #ffc107; }
.paid { background: #28a745; color: #fff; }

.row-item {
    margin: 6px 0;
}
</style>

<div class="container py-4">

    <h3>My Orders</h3>
    <p>Total Orders: <?= $totalOrders ?></p>

    <?php if (!empty($order)): ?>

        <?php foreach ($order as $o): ?>

            <div class="order-card">

                <div class="order-header">
                    <strong>Order #<?= $o->order_no ?></strong>

                    <span class="badge <?= $o->order_status ?>">
                        <?= ucfirst($o->order_status) ?>
                    </span>
                </div>

                <hr>

                <div class="row-item">
                    💰 Total: <?= $o->grand_total ?>
                </div>

                <div class="row-item">
                    💳 Payment: <?= ucfirst($o->payment_status) ?>
                </div>

                <div class="row-item">
                    📅 Date: <?= date('d M Y', strtotime($o->created_at)) ?>
                </div>

                <div style="margin-top:10px;">
                    <a href="<?= siteUrl() ?>/user/order-view/<?= $o->id ?>">
                        View Details
                    </a>

                    <?php if ($o->order_status == 'pending'): ?>
                        | <a href="<?= siteUrl() ?>/user/cancel-order/<?= $o->id ?>">
                            Cancel
                        </a>
                    <?php endif; ?>
                </div>

            </div>

        <?php endforeach; ?>

    <?php else: ?>

        <p>No orders found</p>

    <?php endif; ?>

</div>
