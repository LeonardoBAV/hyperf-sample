<?php
namespace App\Service;

use App\Model\Product;

class ProductService
{
    
    public function create(array $data)
    {
        return Product::create($data);    
    }

    public function update(int $id, array $data)
    {
        $product = Product::find($id);
        $product->update($data);
        return $product->fresh();
    }

    public function delete(int $id)
    {
        return Product::find($id)->delete();
    }

}