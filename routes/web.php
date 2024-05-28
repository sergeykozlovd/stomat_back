<?php

use App\Http\Controllers\AdvertController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppConst;
use App\Http\Controllers\CategoryController;
use App\RouteName;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/', fn() => view('home'))->name(RouteName::HOME);
    Route::view('/users', AppConst::users);

    Route::get('/advert/show', [AdvertController::class, 'show'])->name(RouteName::ADVERT_SHOW);
    Route::get('/advert/show_add_form', [AdvertController::class, 'showAddForm'])->name(RouteName::ADVERT_SHOW_CREATE_FORM);
    Route::get('/advert/show_edit_form', [AdvertController::class, 'showEditForm'])->name(RouteName::ADVERT_SHOW_EDIT_FORM);
    Route::post('/advert/create', [AdvertController::class, 'create'])->name(RouteName::ADVERT_CREATE);
    Route::post('/advert/delete', [AdvertController::class, 'delete'])->name(RouteName::ADVERT_DELETE);
    Route::post('/advert/change', [AdvertController::class, 'change'])->name(RouteName::ADVERT_CHANGE);

    Route::get('/category/show', [CategoryController::class, 'show'])->name(RouteName::CATEGORY_SHOW);
    Route::get('/category/show_add_form', [CategoryController::class, 'showAddForm'])->name(RouteName::CATEGORY_SHOW_CREATE_FORM);
    Route::get('/category/show_edit_form', [CategoryController::class, 'showEditForm'])->name(RouteName::CATEGORY_SHOW_EDIT_FORM);
    Route::post('/category/create', [CategoryController::class, 'create'])->name(RouteName::CATEGORY_CREATE);
    Route::post('/category/delete', [CategoryController::class, 'delete'])->name(RouteName::CATEGORY_DELETE);
    Route::post('/category/change', [CategoryController::class, 'change'])->name(RouteName::CATEGORY_CHANGE);

});

Route::get('/login', [AuthController::class, 'getLogin'])->name(AppConst::login);
Route::post('/login', [AuthController::class, 'postLogin']);
Route::get('/logout', [AuthController::class, 'logout']);
