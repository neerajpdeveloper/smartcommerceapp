
<?php

class CategoryController extends Controller
{
    protected $category;
    protected $product;

    public function __construct()
    {
        $this->category = new Category();
        $this->product  = new Product();
    }

    // 📂 ALL CATEGORIES PAGE
    public function index()
    {
        $data = [
            'categories' => $this->category->getWithProductCount()
        ];

        return $this->view('category', $data);
    }

    // 📦 SINGLE CATEGORY PAGE
    public function detail($slug)
    {
        $category = $this->category->getBySlug($slug);

        if (!$category) {
            echo "Category not found";
            return;
        }

        $data = [
            'category' => $category,
            'products' => $this->product->getByCategory($category->id)
        ];

        return $this->view('category-detail', $data);
    }
}