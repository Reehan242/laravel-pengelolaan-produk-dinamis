<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;

Route::get('/products', [ProductController::class, 'index']); // menampilkan semua product
Route::get('/products/{id}', [ProductController::class, 'show']); // menampilkan product berdasar id
Route::put('/products/{id}', [ProductController::class, 'update']); // mengubah product berdasar id
Route::delete('/products/{id}', [ProductController::class, 'destroy']); // menghapus product berdasar id
Route::post('/products', [ProductController::class, 'store']); // menambah product

// Endpoint untuk properti dinamis
Route::put('/products/{productId}/properties/{propertyId}', [ProductController::class, 'updateProperty']); // mengubah properties dari suatu product
Route::delete('/products/{productId}/properties/{propertyId}', [ProductController::class, 'destroyProperty']); // menghapus properties dari suatu product


