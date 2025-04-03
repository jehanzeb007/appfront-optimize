<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Jobs\SendPriceChangeNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts()
    {
        return $this->productRepository->getAll();
    }

    public function findProduct($id)
    {
        return $this->productRepository->find($id);
    }

    public function updateProduct($id, $request)
    {
        $product = $this->productRepository->find($id);
        $oldPrice = $product->price;
        $updatedProduct = $this->productRepository->update($id, $request);
        if ($oldPrice != $updatedProduct->price) {
            $notificationEmail = env('PRICE_NOTIFICATION_EMAIL', 'admin@example.com');
            try {
                SendPriceChangeNotification::dispatch(
                    $updatedProduct,
                    $oldPrice,
                    $updatedProduct->price,
                    $notificationEmail
                );
            } catch (\Exception $e) {
                Log::error('Failed to dispatch price change notification: ' . $e->getMessage());
            }
        }
    }

    public function deleteProduct($id)
    {
        return $this->productRepository->delete($id);
    }

    public function addProduct($request)
    {

        return $this->productRepository->create($request);
    }
}
