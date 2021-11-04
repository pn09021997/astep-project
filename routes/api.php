<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Session;


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


//API Product
Route::get('/expenses', [ProductController::class, 'index'])->name('expenses.all');

Route::post('/expenses', [ProductController::class, 'store'])->name('expenses.store');

Route::get('/expenses/{expense}', [ProductController::class, 'show'])->name('expenses.show');

Route::patch('/expenses/{expense}', [ProductController::class, 'update'])->name('expenses.update');

Route::delete('/expenses/{expense}', [ProductController::class, 'destroy'])->name('expense.destroy');
