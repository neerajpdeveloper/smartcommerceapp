<?php
ob_start();
?>

<div style="font-family: Arial, sans-serif; max-width: 700px; margin: auto; background: #ffffff; border: 1px solid #eee;">

    <div style="background: #111827; padding: 25px; text-align: center;">
        <h1 style="color: #fff; margin: 0; font-size: 24px;">Order Confirmed 🎉</h1>
    </div>

    <div style="padding: 30px; color: #333333; line-height: 1.5;">

        <p>Hi <strong><?= htmlspecialchars($customer_name) ?></strong>,</p>

        <p>Thank you for your order. Your order has been received successfully and is now being processed.</p>

        <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse; border: 1px solid #eee; margin-top: 20px;">
            
            <tr>
                <td style="border-bottom: 1px solid #eee; width: 40%;"><strong>Order Number</strong></td>
                <td style="border-bottom: 1px solid #eee;">#<?= htmlspecialchars($order_no) ?></td>
            </tr>

            <tr style="background: #f9f9f9;">
                <td style="border-bottom: 1px solid #eee;"><strong>Order Date</strong></td>
                <td style="border-bottom: 1px solid #eee;"><?= htmlspecialchars($order_date) ?></td>
            </tr>

            <tr>
                <td style="border-bottom: 1px solid #eee;"><strong>Payment Method</strong></td>
                <td style="border-bottom: 1px solid #eee; text-transform: uppercase;"><?= htmlspecialchars($payment_method) ?></td>
            </tr>

            <tr style="background: #f9f9f9;">
                <td style="border-bottom: 1px solid #eee;"><strong>Payment Status</strong></td>
                <td style="border-bottom: 1px solid #eee;">
                    <span style="font-weight: bold; color: <?= strtolower($payment_status) === 'paid' ? '#10B981' : '#F59E0B' ?>;">
                        <?= htmlspecialchars(ucfirst($payment_status)) ?>
                    </span>
                </td>
            </tr>

            <tr>
                <td style="border-bottom: 1px solid #eee;"><strong>Order Status</strong></td>
                <td style="border-bottom: 1px solid #eee;">
                    <span style="font-weight: bold; color: #3B82F6;">
                        <?= htmlspecialchars(ucfirst($order_status)) ?>
                    </span>
                </td>
            </tr>

            <tr style="background: #f9f9f9;">
                <td><strong>Total Amount</strong></td>
                <td style="font-size: 16px; font-weight: bold; color: #111827;">
                    <?= htmlspecialchars($currency_symbol) ?> <?= htmlspecialchars($amount) ?>
                </td>
            </tr>

        </table>

        <div style="margin-top: 30px; text-align: center;">
            <a href="<?= siteUrl() ?>" style="background: #111827; color: #fff; text-decoration: none; padding: 12px 25px; border-radius: 5px; display: inline-block; font-weight: bold;">
                Visit Website
            </a>
        </div>

        <p style="margin-top: 30px;">
            If you have any questions regarding your order, feel free to contact our support team.
        </p>

        <p>
            Regards,<br>
            <strong><?= htmlspecialchars(setting()->site_name) ?></strong>
        </p>

    </div>

</div>

<?php
$content = ob_get_clean();

include __DIR__ . '/layout.php';