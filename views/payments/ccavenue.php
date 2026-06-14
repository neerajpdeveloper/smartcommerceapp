<!DOCTYPE html>
<html>
<head>
    <title>Redirecting...</title>
</head>
<body>

<form
    id="ccavenueForm"
    method="post"
    action="<?= $this->paymentUrl(); ?>"
>
    <input
        type="hidden"
        name="encRequest"
        value="<?= $encryptedRequest ?>"
    >

    <input
        type="hidden"
        name="access_code"
        value="<?= $this->gateway->extra_key ?>"
    >
</form>

<script>
document.getElementById(
    'ccavenueForm'
).submit();
</script>

</body>
</html>