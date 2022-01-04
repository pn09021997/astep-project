<?php

use App\Http\Controllers\ResetPasswordController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\URL;

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

Route::get('/{path?}', function () {
    return view('welcome');
});

Route::get('/login',[UserController::class,'loginview'])->middleware('checklogin')->name('login');
Route::get('/register',[UserController::class,'registerview'])->middleware('checklogin');
Route::get('/info',[UserController::class,'infoview'])->middleware('auth:api');
Route::get('/password',function (){
    return view('password');
})->middleware('auth:api');

Route::resource('/product', 'App\Http\Controllers\ProductController');
Route::get('/searchProduct',[ProductController::class,'getSearch'])->name('product.search');
Route::get('/verify/verify',[UserController::class,'UserVerifyEmail']);

Route::get('/forgot-pw/send-email-forgot-pw/',function (){
        $url_post = URL::to('/').'/forgot-pw/send-email-forgot-pw';
   return view("email.FillEmailForgotPw",['url_post'=>$url_post]);
});
Route::post('/forgot-pw/send-email-forgot-pw',[ResetPasswordController::class,'recive_email']);
Route::get('password-reset/verify',[ResetPasswordController::class,'getformUpdate']);
Route::post('password-reset',[ResetPasswordController::class,'updatePassWord']);

//Route::post('/forgot-pw/reset-password', 'ResetPasswordController@sendMail');
//Route::post('/forgot-pw/reset-password/{token}', 'ResetPasswordController@reset');
