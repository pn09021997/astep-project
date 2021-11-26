<?php

use App\Http\Controllers\HomePageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ProductisHighLight;


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

Route::post('/login',[UserController::class,'login'])->middleware('checklogin');
Route::post('/register',[UserController::class,'register'])->middleware('checklogin');
Route::get('/info',[UserController::class,'infoview'])->middleware('auth:api')->name('userinfo');
Route::post('/info',[UserController::class,'infoPost'])->middleware('auth:api');
Route::post('/password',[UserController::class,'PasswordUpdate'])->middleware('auth:api');
Route::get('/logout',[UserController::class,'UserLogout'])->middleware('auth:api');
Route::get('/home-page-lastest-product',[HomePageController::class,'GetProductIsLastest']);
Route::get('/category-is-ramdom',[HomePageController::class,'GetCategoryIsRamdom']);
Route::get('/productIsBoughtMuch',[ProductisHighLight::class,'getProductIsBoughtMuch']); // Api get product is Bought Much

