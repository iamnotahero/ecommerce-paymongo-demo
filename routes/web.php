<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymongoController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
Route::get('/home', [HomeController::class, 'index']);
Route::get('/', [ProductController::class, 'index']);
Route::get('/product/{product}', [ProductController::class, 'show']);

Route::post('/paymongo/create-checkout', [PaymongoController::class, 'createCheckout']);
Route::post('/paymongo/attach', [PaymongoController::class, 'attachPayment']);
Route::get('/payment/success', [PaymongoController::class, 'success']);

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');