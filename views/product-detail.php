<h1><?= $product->name ?></h1>

<div>
    Category: <?= $product->category_name ?>
</div>

<div>
    Brand: <?= $product->brand_name ?>
</div>

<h2><?= price($product->price) ?></h2>

<!-- QUANTITY -->
<div style="margin:15px 0;">
    <button onclick="decreaseQty()">-</button>
    
    <input type="text" id="qty" value="1" style="width:40px;text-align:center;">

    <button onclick="increaseQty()">+</button>
</div>

<!-- ADD TO CART -->
<button onclick="addToCart(<?= $product->id ?>)" style="
    padding:10px 15px;
    background:black;
    color:white;
    border:none;
    cursor:pointer;
">
    Add To Cart
</button>

<script>
function increaseQty(){
    let qty = document.getElementById('qty');
    qty.value = parseInt(qty.value) + 1;
}

function decreaseQty(){
    let qty = document.getElementById('qty');
    if(qty.value > 1){
        qty.value = parseInt(qty.value) - 1;
    }
}

// AJAX Add to cart
function addToCart(productId){

    let qty = document.getElementById('qty').value;

    fetch("<?= siteUrl() ?>/cart/add", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "product_id=" + productId + "&qty=" + qty
    })
    .then(res => res.text())
    .then(data => {
        alert("Product added to cart!");
    });
}
</script>