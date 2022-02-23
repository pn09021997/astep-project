<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductisHighLight;
use App\Models\user_cart;
use App\Http\Controllers\HomePageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CartController;
// use App\Http\Controllers\ProductisHighLight;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\CommentController;

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

Route::get('/watch-comment',[CommentController::class,'WatchCommentNotAuth']);
Route::post('/login',[UserController::class,'login']); // Api Login
Route::post('/register',[UserController::class,'register']); // Api Register
Route::get('/productIsInteresting',[ProductisHighLight::class,'getProductisInteresting']); // Api get product is cart much
Route::get('/productIsBoughtMuch',[ProductisHighLight::class,'getProductIsBoughtMuch']); // Api get product is Bought Much
//Route::resource('/product', 'App\Http\Controllers\ProductController')->middleware(['auth:api','role']);
//Route::resource('/user', 'App\Http\Controllers\UserController')->middleware(['auth:api','role']);
//Route::resource('/category', 'App\Http\Controllers\CategoryController')->middleware(['auth:api','role']);
Route::get('/home-page-lastest-product',[HomePageController::class,'GetProductIsLastest']);
Route::get('/category-is-ramdom',[HomePageController::class,'GetCategoryIsRamdom']);
Route::get('/searchProduct/{key}',[ProductController::class,'getSearch'])->name('product.search');
Route::get('/searchCategory/{key}',[CategoryController::class,'getSearch'])->name('category.search');
Route::get('/searchUser/{key}',[UserController::class,'getSearch'])->name('user.search');
Route::get('/categoriesPage/{key}',[CategoryController::class,'getProductByCategoryId'])->name('categoriesPage');
Route::get('/categoriesPage/{key}/{filter}',[ProductController::class,'filterProduct'])->name('product.filter');
Route::get('/product_detail',[ProductController::class,'GetProductById']);

// Gom nhóm api có auth lại
Route::middleware('auth:api')->group(function (){
    Route::get('/watch-comment-auth',[CommentController::class,'WatchComment']);
    Route::get('/info',[UserController::class,'infoview'])->name('userinfo'); // Api Get info user
    Route::post('/info',[UserController::class,'infoPost']); // Api  Update info user
    Route::post('/password',[UserController::class,'PasswordUpdate']);// APi Update PassWord
    Route::get('/logout',[UserController::class,'UserLogout']); // Api Logout user
    Route::get('/cart_user',[CartController::class,'Show']); // Api User Cart
    Route::post('/cart_create',[CartController::class,'Create']); // Api Create
    Route::post('/cart_update',[CartController::class,'Edit']); // Api cart Update
    Route::get('/cart_delete',[CartController::class,'Delete']); // Api Cart Delete
});
Route::middleware(['auth:api','role'])->group(function (){

});
