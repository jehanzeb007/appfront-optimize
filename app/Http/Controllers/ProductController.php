<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function products()
    {
        $products = $this->productService->getAllProducts();
        return view('admin.products', compact('products'));
    }

    public function editProduct($id)
    {
        $product = $this->productService->findProduct($id);
        return view('admin.edit_product', compact('product'));
    }

    public function updateProduct($id, ProductRequest $request)
    {
        try {
            $this->productService->updateProduct($id, $request);
            return redirect()->route('admin.products')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            Log::error('Product update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating product');
        }
    }

    public function deleteProduct($id)
    {
        $this->productService->deleteProduct($id);
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully');
    }

    public function addProductForm()
    {
        return view('admin.add_product');
    }

    public function addProduct(ProductRequest $request)
    {
        try {
            $this->productService->addProduct($request);
            return redirect()->route('admin.products')->with('success', 'Product added successfully');
        } catch (\Exception $e) {
            Log::error('Product addition failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error adding product');
        }
    }
}
