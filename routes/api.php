<?php

use App\Http\Controllers\AdvertController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login',[AuthController::class,'apiLogin']);
Route::post('/register',[AuthController::class,'apiRegister']);
Route::post('/recovery',[AuthController::class,'apiRecovery']);
Route::post('/send_code',[AuthController::class, 'apiSendRegisterCode']);
Route::post('/send_recovery_code',[AuthController::class,'apiSendRecoveryCode']);
Route::get('/adverts',[AdvertController::class,'apiGetAll']);
Route::get('/categories',[CategoryController::class, 'apiGetCategories']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [UserController::class, 'user']);
    Route::post('/change_user', [UserController::class, 'change_user']);
    Route::post('/logout', [AuthController::class, 'apiLogout']);
    Route::post('/add_purchase_to_cart', [PurchaseController::class, 'apiAddPurchaseToCart']);
    Route::get('/get_cart_purchases', [PurchaseController::class, 'apiGetPurchases']);
    Route::post('/change_purchase_state', [PurchaseController::class, 'apiChangePurchaseState']);
});
