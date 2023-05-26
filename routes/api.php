<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Http\Request;
use App\Http\Controllers\V1\RegisterController;
use App\Http\Controllers\V1\LoginController;
use App\Http\Controllers\V1\Auth\LogoutController;
use App\Http\Controllers\V1\ForgotPasswordController;
use App\Http\Controllers\V1\Auth\ResetPasswordController;
use App\Http\Controllers\V1\Admin\UserController;
use App\Http\Controllers\V1\Admin\FoodController;
use App\Http\Controllers\V1\Admin\ReservationController;
use App\Http\Controllers\V1\Admin\ChefController;
use App\Http\Controllers\V1\Customer\Auth\CartController;
use App\Http\Controllers\V1\Customer\Auth\OrderController;
use App\Http\Controllers\V1\Customer\Auth\CartitemController;
use App\Http\Controllers\V1\Customer\Auth\ProfileController;
use App\Http\Controllers\V1\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

   Route::group(['v1'], function() {

            Route::get('/foods', [FoodController::class, 'index']);
            Route::get('/foods/{id}', [FoodController::class, 'show']);
            Route::get('/chefs', [ChefController::class, 'index']);
            Route::get('/count-chefs', [ChefController::class, 'getTotalChef']);
            Route::get('/chefs/{id}', [ChefController::class, 'show']);

      //....auth....//
      Route::group(['prefix'=> 'auth'], function() {
        Route::post('register', [RegisterController::class, 'register']);
        Route::post('login', [LoginController::class, 'login']);
        Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
     Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::post('logout', [LogoutController::class, 'logout']);
        Route::post('/email/verification-notification', [VerifyEmailController::class, 'resendNotification'])->name('verification.send');
        Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']); 

     });
 });
           

         Route::group(['middleware' => 'me', 'middleware' => 'auth:sanctum'], function() {
 
            Route::post('/profiles', [ProfileController::class, 'updateProfile']);
            Route::post('/change-password', [ProfileController::class, 'changePassword']);

         });


           Route::group(['middleware' => ['role:super-admin'], 'prefix' => 'admin'], function () {
 
            Route::get('/users', [UserController::class, 'index']);
            Route::get('/count-users', [UserController::class, 'getTotalUser']);
            Route::post('/users', [UserController::class, 'store']);
            Route::get('/users/{user}', [UserController::class, 'show']);
            Route::put('/users/{user}', [UserController::class, 'update']);
            Route::DELETE('/users/{user}', [UserController::class, 'destroy']);
            Route::get('/users/{search}', [UserController::class, 'searchUser']);
            Route::get('/count-reservations', [ReservationController::class, 'getTotalUser']);

           });

           Route::group(['middleware' => ['role:resturant-owner'], 'prefix' => 'owner'], function () {
          
            Route::post('/foods', [FoodController::class, 'store']);
            Route::put('/foods/{id}', [FoodController::class, 'update']);
            Route::DELETE('/foods/{id}', [FoodController::class, 'destroy']);
            Route::get('/reservations', [ReservationController::class, 'index']);
            Route::post('/reservations', [ReservationController::class, 'store']);
            Route::get('/reservations/{id}', [ReservationController::class, 'show']);
            Route::put('/reservations/{id}', [ReservationController::class, 'update']);
            Route::DELETE('/reservations/{id}', [ReservationController::class, 'destroy']);
            Route::get('/reservations/{search}', [ReservationController::class, 'searchReservation']);
            Route::post('/chefs', [ChefController::class, 'store']);
            Route::put('/chefs/{chef}', [ChefController::class, 'update']);
            Route::DELETE('/chefs/{chef}', [ChefController::class, 'destroy']);
            Route::get('/chefs/{search}', [ChefController::class, 'searchChef']);
           });

      //..Frontend..//

     
  });