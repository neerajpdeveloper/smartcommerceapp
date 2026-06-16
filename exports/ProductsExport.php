<?php

class ProductsExport implements ExportInterface
{
    protected $productsModel;
    protected $userId;

    public function __construct()
    {
        $this->productsModel = new Product();
    }

    public function headings(): array
    {
        return [
            'Product Name',
            'Category Name',
            'Brand Name',
            'Stock',
            'Price',
            'Description'
        ];
    }

    public function collection(): array
    {
            return $this->productsModel->getAll();
    }

public function map($row): array
{
    return [
        is_array($row) ? $row['name'] : $row->name,
        is_array($row) ? $row['category_name'] : $row->category_name,
        is_array($row) ? $row['brand_name'] : $row->brand_name,
        is_array($row) ? $row['stock'] : $row->stock,
        is_array($row) ? $row['price'] : $row->price,
        is_array($row) ? $row['description'] : $row->description,
    ];
}
}