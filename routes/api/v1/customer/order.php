<?php

use App\Http\Controllers\V1\Customer\Auth\OrderController;

use Illuminate\Support\Facades\Route;

Route::post('/place-order', [OrderController::class, 'placeOrder']);

