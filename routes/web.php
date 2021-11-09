<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login',[UserController::class,'loginview'])->name('login'); // Route login
Route::get('/register',[UserController::class,'registerview']); // Route Register
Route::get('/info',[UserController::class,'infoview'])->middleware('auth:api'); // Route info user
Route::get('/password',function (){
    return view('password');
})->middleware('auth:api'); // Route Password
