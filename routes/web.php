<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route to admin page
Route::get('/admin', function () {
    return view('admin');
});

Route::get('{any}', function () {
    return view('welcome'); // or wherever your React app is bootstrapped.
})->where('any', '.*');




Route::get('/login',[UserController::class,'loginview'])->middleware('checklogin')->name('login');
Route::get('/register',[UserController::class,'registerview'])->middleware('checklogin');
Route::get('/info',[UserController::class,'infoview'])->middleware('auth:api');
Route::get('/password',function (){
    return view('password');
})->middleware('auth:api');

Route::resource('/product', 'App\Http\Controllers\ProductController');
Route::get('/searchProduct',[ProductController::class,'getSearch'])->name('product.search');
Route::get('/verify/verify',[UserController::class,'UserVerifyEmail']);

