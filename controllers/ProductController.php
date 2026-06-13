<?php 
class ProductController extends Controller
{
    protected $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    // PRODUCT LIST
    public function index()
    {
        $data['products'] = $this->product->getAll();

        return $this->view('products', $data);
    }

    // PRODUCT DETAIL
    public function productBySlug($slug)
    {
        $data['product'] = $this->product->getBySlug($slug);

        return $this->view('product-detail', $data);
    }
}