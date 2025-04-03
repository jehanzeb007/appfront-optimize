<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ExchangeRateService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $exchangeRateService;

    // Inject ExchangeRateService
    public function __construct(ExchangeRateService $exchangeRateService, ProductService $productService)
    {
        $this->exchangeRateService = $exchangeRateService;
        $this->productService = $productService;
    }

    public function index()
    {
        $products = Product::all();
        $exchangeRate = $this->exchangeRateService->getExchangeRate();

        return view('home.list', compact('products', 'exchangeRate'));
    }

    public function show(Request $request)
    {
        $id = $request->route('product_id');
        $product = $this->productService->findProduct($id);
        $exchangeRate = $this->exchangeRateService->getExchangeRate();

        return view('home.show', compact('product', 'exchangeRate'));
    }
}
