<?php

use App\Http\Controllers\API\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductViewController;

// Route utama
Route::get('/', [ProductViewController::class, 'index']);

Route::delete('/products/{id}',[ProductController::class,'destroy']);