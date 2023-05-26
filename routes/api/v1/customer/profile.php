<?php

use App\Http\Controllers\V1\Customer\Auth\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('view-profile', [ProfileController::class, 'viewProfile']);
Route::post('update-profile', [ProfileController::class, 'updateProfile']);
Route::post('change-password', [ProfileController::class, 'changePassword']);

