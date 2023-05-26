<?php

use App\Http\Controllers\V1\Admin\ChefController;

use Illuminate\Support\Facades\Route;



Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin'], function () {

      
      

  }); 