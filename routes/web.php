<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/products', [FrontendController::class, 'products'])->name('products');
Route::get('/products/family/{family}', [FrontendController::class, 'productsByFamily'])->name('products.family');
Route::get('/products/{slug}', [FrontendController::class, 'productDetail'])->name('products.show');
Route::get('/inspirations', [FrontendController::class, 'inspirations'])->name('inspirations');
Route::get('/inspirations/{slug}', [FrontendController::class, 'inspirationDetail'])->name('inspirations.show');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
