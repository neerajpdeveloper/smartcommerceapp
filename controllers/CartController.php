<?php 
class CartController extends Controller
{
    protected $cartModel;
    protected $productModel;

    public function __construct()
    {
        $this->cartModel = new Cart();
        $this->productModel = new Product();
    }

 public function index()
    {
        if (!isLoggedIn()) {

            header('Location: ' . siteUrl() . '/login');
            exit;
        }

        $userId = user()['id'];

        $data = [
            'cartItems' => $this->cartModel->getByUser($userId),
            'cartTotal' => $this->cartModel->totalAmount($userId)
        ];

        return $this->view('cart', $data);
    }

    public function add()
    {
        // Login Check
        if (!isLoggedIn()) {

            $_SESSION['error'] = 'Please login first';

            header('Location: ' . siteUrl() . '/login');
            exit;
        }

        // Validate Input
        $productId = (int)($_POST['product_id'] ?? 0);
        $qty       = (int)($_POST['qty'] ?? 1);

        if ($productId <= 0) {

            $_SESSION['error'] = 'Invalid product';

            header('Location: ' . siteUrl());
            exit;
        }

        if ($qty < 1) {
            $qty = 1;
        }

        // Product Check
        $product = $this->productModel->getById($productId);

        if (!$product) {

            $_SESSION['error'] = 'Product not found';

            header('Location: ' . siteUrl());
            exit;
        }

        // Add To Cart
        $this->cartModel->add(
            user()['id'],
            $productId,
            $qty
        );

        $_SESSION['success'] = 'Product added to cart successfully';

        header('Location: ' . siteUrl() . '/cart');
        exit;
    }

    public function update()
{
    $cartId = (int)$_POST['cart_id'];
    $type   = $_POST['type'];

    $cart = new Cart();

    $cart->updateQty(
        $cartId,
        $type
    );

    echo json_encode([
        'status' => true
    ]);

    exit;
}  

public function remove($cartId)
{
    if (!isLoggedIn()) {

        header('Location: ' . siteUrl() . '/login');
        exit;
    }

    $this->cartModel->remove(
        $cartId,
        user()['id']
    );

    $_SESSION['success'] = 'Item removed from cart';

    header('Location: ' . siteUrl() . '/cart');
    exit;
}

}