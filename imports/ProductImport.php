<?php

class ProductImport implements ImportInterface
{
    private Product $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function import(array $rows)
    {
        unset($rows[0]); // Header remove

        foreach ($rows as $row) {

            if (empty(array_filter($row))) {
                continue;
            }

            $name        = trim($row[0] ?? '');
            $categoryId  = (int)($row[1] ?? 0);
            $brandId     = (int)($row[2] ?? 0);
            $price       = (float)($row[3] ?? 0);
            $stock       = (int)($row[4] ?? 0);
            $description = trim($row[5] ?? '');

            if (empty($name)) {
                continue;
            }

            $this->product->create([
                'name'         => $name,
                'category_id'  => $categoryId,
                'brand_id'     => $brandId,
                'price'        => $price,
                'stock'        => $stock,
                'description'  => $description,
                'created_at'   => date('Y-m-d H:i:s')
            ]);
        }

        return true;
    }
}