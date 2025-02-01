<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductViewController;

// Route utama
Route::get('/', [ProductViewController::class, 'index']);