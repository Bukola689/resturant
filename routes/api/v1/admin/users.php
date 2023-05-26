<?php

use App\Http\Controllers\V1\Admin\UserController;

//use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin'], function () {

        Route::get('/users', [UserController::class, 'index']);
        Route::get('/count-users', [UserController::class, 'getTotalUser']);
        Route::post('/users', [UserController::class, 'store']);
        Route::get('/users/{user}', [UserController::class, 'show']);
        Route::put('/users/{user}', [UserController::class, 'update']);
        Route::DELETE('/users/{user}', [UserController::class, 'destroy']);
        Route::get('/users/{search}', [UserController::class, 'searchUser']);

  }); 