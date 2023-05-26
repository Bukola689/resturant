<?php

use App\Http\Controllers\V1\Customer\Auth\CartController;

use Illuminate\Support\Facades\Route;

Route::post('add-cart', [CartController::class, 'addToCart']);
Route::get('view-cart', [CartController::class, 'viewCart']);
Route::post('increment', [CartController::class, 'increment']);
Route::post('decrement', [CartController::class, 'decrement']);
Route::post('remove-cart', [CartController::class, 'removeCart']);

