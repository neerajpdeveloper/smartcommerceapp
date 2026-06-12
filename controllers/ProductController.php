<?php 
class ProductController extends Controller
{
    protected $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    // HOME PAGE
    public function home()
    {
        $data = [
            'featured' => $this->product->getFeatured(),
            'products' => $this->product->getAll()
        ];

        require 'views/home.php';
    }

    // PRODUCT LIST
    public function products()
    {
        $data['products'] = $this->product->getAll();

        require 'views/products.php';
    }

    // PRODUCT DETAIL
    public function detail($id)
    {
        $data['product'] = $this->product->getById($id);

        require 'views/product-detail.php';
    }
}