
<?php

class BrandController extends Controller
{
    protected $brand;
    protected $product;

    public function __construct()
    {
        $this->brand = new Brand();
        $this->product  = new Product();
    }

    // 📂 ALL CATEGORIES PAGE
    public function index()
    {
        $data = [
            'brands' => $this->brand->getWithProductCount()
        ];

        return $this->view('brands', $data);
    }

    // 📦 SINGLE CATEGORY PAGE
    public function detail($slug)
    {
        $brands = $this->brand->getBySlug($slug);

        if (!$category) {
            echo "brands not found";
            return;
        }

        $data = [
            'category' => $category,
            'products' => $this->product->getByCategory($category->id)
        ];

        return $this->view('brands-detail', $data);
    }
}