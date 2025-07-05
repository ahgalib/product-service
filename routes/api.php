<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/search', [ProductController::class, 'search']);
Route::get('/products/autocomplete', [ProductController::class, 'autocomplete']);
