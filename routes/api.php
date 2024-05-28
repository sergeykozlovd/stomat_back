<?php

use App\Http\Controllers\ApiAdvertController;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiCategoryController;
use App\Http\Controllers\ApiPurchaseController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::post('/login',[ApiAuthController::class,'login']);
Route::post('/register',[ApiAuthController::class,'register']);
Route::post('/recovery',[ApiAuthController::class,'recovery']);
Route::post('/send_code',[ApiAuthController::class, 'sendRegisterCode']);
Route::post('/send_recovery_code',[ApiAuthController::class,'sendRecoveryCode']);
Route::get('/adverts',[ApiAdvertController::class,'getAll']);
Route::get('/categories',[ApiCategoryController::class, 'getCategories']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [UserController::class, 'user']);
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    Route::post('/add_purchase_to_cart', [ApiPurchaseController::class, 'addPurchaseToCart']);
    Route::get('/get_cart_purchases', [ApiPurchaseController::class, 'getPurchases']);
    Route::post('/change_purchase_state', [ApiPurchaseController::class, 'changePurchaseState']);
});
