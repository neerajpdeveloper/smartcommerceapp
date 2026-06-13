<?php

class HomeController extends Controller
{
    protected $product;
    protected $category;
    protected $brands;

    public function __construct()
    {
        $this->product = new Product();
        $this->category = new Category();
        $this->brands = new Brand();
    }

    public function index()
    {
        $data = [
            'featured'   => $this->product->getFeatured(8),
            'new'        => $this->product->getNew(8),
            'categories' => $this->category->getAll(),
            'brands'     => $this->brands->getAll(),
        ];

        return $this->view('home', $data);
    }
}