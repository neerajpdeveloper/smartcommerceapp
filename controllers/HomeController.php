<?php

class HomeController extends Controller
{
    protected $product;
    protected $category;

    public function __construct()
    {
        $this->product = new Product();
        $this->category = new Category();
    }

    public function index()
    {
        $data = [
            'featured'   => $this->product->getFeatured(8),
            'new'        => $this->product->getNew(8),
            'categories' => $this->category->getAll()
        ];

        return $this->view('home', $data);
    }
}