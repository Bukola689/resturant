<?php

use App\Http\Controllers\V1\Admin\AdminCartController;

use Illuminate\Support\Facades\Route;




        Route::get('/carts', [AdminCartController::class, 'allCart']);
      

