<?php

namespace App\Repositories;

use App\Models\Product;
use App\Traits\ImageHandler;

class ProductRepository
{
    use ImageHandler;

    public function getAll()
    {
        return Product::all();
    }

    public function find($id)
    {
        return Product::find($id);
    }

    public function update($id, $data)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return null;
        }
        if ($data->hasFile('image')) {
            if ($product->image && file_exists(public_path($product->image))) {
                $this->deleteImage($product->image);
            }
            $product->image = $this->handleImageUpload($data->file('image'));
        }
        $product->update($data->except('image'));
        return $product;
    }


    public function delete($id)
    {
        $product = Product::find($id);
        $this->deleteImage($product->image);
        return Product::destroy($id);
    }

    public function create($data)
    {
        $product = Product::create([
            'name' => $data->name,
            'description' => $data->description,
            'price' => $data->price,
            'image' => $data->hasFile('image') ? $this->handleImageUpload($data->file('image')) : 'product-placeholder.jpg',
        ]);

        return $product;
    }
}
