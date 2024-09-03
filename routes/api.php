<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ProductController::class, "index"]);
Route::get('/products/{id}', [ProductController::class, "getProduct"]);
Route::post('/products', [ProductController::class, "createProduct"]);
Route::put('/products/{id}', [ProductController::class, "updateProduct"]);
Route::delete('/products/{id}', [ProductController::class, "deleteProduct"]);