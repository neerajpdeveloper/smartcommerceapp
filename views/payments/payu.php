<form
    action="<?= $action ?>"
    method="post"
    id="payuForm"
>

    <input type="hidden" name="key" value="<?= $key ?>">
    <input type="hidden" name="txnid" value="<?= $txnid ?>">
    <input type="hidden" name="amount" value="<?= $amount ?>">
    <input type="hidden" name="productinfo" value="<?= $productInfo ?>">
    <input type="hidden" name="firstname" value="<?= $firstname ?>">
    <input type="hidden" name="email" value="<?= $email ?>">

    <input type="hidden" name="phone" value="9999999999">

    <input type="hidden" name="surl" value="<?= $successUrl ?>">
    <input type="hidden" name="furl" value="<?= $failureUrl ?>">

    <input type="hidden" name="hash" value="<?= $hash ?>">

</form>

<script>
document.getElementById('payuForm').submit();
</script>