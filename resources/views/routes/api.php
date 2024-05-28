<?php

use App\Http\Controllers\ApiAdvertController;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiCategoryController;
use App\Http\Controllers\ApiPurchaseController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

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
