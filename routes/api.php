<?php

use App\Http\Controllers\api\RestaurantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\mail\mailController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('creat-user', [UserController::class, 'creatUser']);
// 


Route::put('update-user/{id}', [UserController::class, 'upateUser']);
Route::delete('delete-user/{id}', [UserController::class, 'deleteUser']);
Route::get('send-mail', [mailController::class, 'sendEmail']);
Route::get('get-restaurant', [RestaurantController::class, 'getRestaurant']);
Route::post('order', [OrderController::class, 'creatOrder']);

Route::post('login', [UserController::class, 'login']);

Route::get('unauthenticated', [UserController::class, 'unauthenticated'])->name('unauthenticated');

//secure route using middleware 
Route::middleware('auth:api')->group(function () {
    Route::get('get-users', [UserController::class, 'getUsers']);
    Route::get('get-user-detail/{id}', [UserController::class, 'getUserDetail']);
    Route::post('logout',[UserController::class,'logout']);
});


