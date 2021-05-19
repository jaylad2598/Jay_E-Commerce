<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;

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

/* Route::get('/', function () {
    return view('welcome');
}); */

Auth::routes();

Route::get('product-index',[ProductController::class,'index']);
Route::get('add-product',[ProductController::class,'create']);
Route::post('product-index',[ProductController::class,'store']);
Route::get('/edit-product/{id}',[ProductController::class,'edit']);
Route::post('/product/update/{id}',[ProductController::class,'update']);
Route::get('/delete/{id}',[ProductController::class,'destroy']);
Route::get('/status/{id}',[ProductController::class,'updateStatus']);
Route::get('/activeproduct-index',[ProductController::class,'activeproduct']);

Route::post('/add_to_cart',[ProductController::class,'addtocart']);
Route::get('/cart-index',[ProductController::class,'cartlist']);

Route::get('user-index',[UserController::class,'index']);
Route::get('/edit-user/{id}',[UserController::class,'edit']);
Route::post('/update/{id}',[UserController::class,'update']);
Route::get('/delete/{id}',[UserController::class,'destroy']);
Route::get('/status/{id}',[UserController::class,'updateStatus']);

Route::get('/home',[HomeController::class, 'index'])->name('home');
Route::get('admin/home',[HomeController::class, 'adminhome'])->name('admin.home')->middleware('is_admin');