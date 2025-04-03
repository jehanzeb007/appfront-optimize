<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/products/{product_id}', [HomeController::class, 'show'])->name('products.show');

Route::get('/login', [AdminController::class, 'loginPage'])->name('login');
Route::post('/login', [AdminController::class, 'login'])->name('login.submit');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [ProductController::class, 'products'])->name('admin.products');
    Route::get('/products', [ProductController::class, 'products'])->name('admin.products');
    Route::get('/products/add', [ProductController::class, 'addProductForm'])->name('admin.add.product');
    Route::post('/products/add', [ProductController::class, 'addProduct'])->name('admin.add.product.submit');
    Route::get('/products/edit/{id}', [ProductController::class, 'editProduct'])->name('admin.edit.product');
    Route::post('/products/edit/{id}', [ProductController::class, 'updateProduct'])->name('admin.update.product');
    Route::get('/products/delete/{id}', [ProductController::class, 'deleteProduct'])->name('admin.delete.product');
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
});
