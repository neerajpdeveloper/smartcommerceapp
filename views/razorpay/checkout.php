<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
var options = {
    key: "<?= $gateway->client_id ?>",
    amount: "<?= $data['amount'] ?>",
    currency: "<?= $data['currency'] ?>",
    order_id: "<?= $data['razorpay_order_id'] ?>",

    handler: function (response) {

        window.location.href =
            "<?= siteUrl() ?>/razorpay-success/<?= $orderId ?>" +
            "?razorpay_payment_id=" + response.razorpay_payment_id +
            "&razorpay_order_id=" + response.razorpay_order_id +
            "&razorpay_signature=" + response.razorpay_signature;
    },

    modal: {
        ondismiss: function () {
            window.location.href =
                "<?= siteUrl() ?>/razorpay-cancel/<?= $orderId ?>";
        }
    }
};

var rzp = new Razorpay(options);
rzp.open();
</script>