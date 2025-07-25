

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProductTagController;
// Product inventory routes

// Route::get('/products', [ProductController::class, 'index']);
// Route::post('/products', [ProductController::class, 'store']);
// Route::get('/search', [ProductController::class, 'search']);
// Route::get('/products/autocomplete', [ProductController::class, 'autocomplete']);

// Route::prefix('products')->group(function () {
//     Route::put('{id}', [ProductController::class, 'update']);
//     Route::delete('{id}', [ProductController::class, 'destroy']);
// });


// Route::controller(ProductController::class)->prefix('products')->group(function () {
//     Route::get('/', 'index');
//     Route::post('/', 'store');
//     Route::get('/search', 'search');
//     Route::get('/autocomplete', 'autocomplete');
//     Route::put('/{id}', 'update');
//     Route::delete('/{id}', 'destroy');
// });


use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\SubCategoryController;

// Product routes
Route::controller(ProductController::class)->prefix('products')->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/search', 'search');
    Route::get('/autocomplete', 'autocomplete');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

// Optimized resource routes
Route::apiResource('categories', CategoryController::class);
Route::apiResource('brands', BrandController::class);
Route::apiResource('subcategories', SubCategoryController::class);
Route::apiResource('product-variants', ProductVariantController::class);
Route::post('product-variants/{id}/adjust-stock', [ProductVariantController::class, 'adjustStock']);
Route::apiResource('product-images', ProductImageController::class);
Route::apiResource('product-tags', ProductTagController::class);