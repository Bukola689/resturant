<?php

use App\Http\Controllers\V1\Customer\Auth\CartitemController;

use Illuminate\Support\Facades\Route;

Route::get('/cartitem', [CartitemController::class, 'cartItem']);