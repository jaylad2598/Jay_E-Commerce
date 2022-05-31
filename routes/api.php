<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiProductController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/apiproducts',[ApiProductController::class,'create']);
Route::get('/apiproduct',[ApiProductController::class,'show']);
Route::get('/apiproduct/{id}',[ApiProductController::class,'showbyid']);
Route::post('/apiproductupdate/{id}',[ApiProductController::class,'updatebyid']);
Route::delete('/apiproductdelete/{id}', [ApiProductController::class,'destroy']);
Route::post('/apigetproduct',[ApiProductController::class,'getProduct']);
Route::post('/apiorderData',[ApiProductController::class,'makeOrder']);
Route::post('/getPaymentDetails',[ApiProductController::class,'getPaymentDetails']);
Route::post('/addToCart',[ApiProductController::class,'addToCart']);
    





Route::get('/showUser',[ApiProductController::class,'showUser']);
Route::post('/insertChatData/{id}',[ApiProductController::class,'insertChatData']);
Route::get('/getChatData/{id}',[ApiProductController::class,'getChatData']);
// Route::get('/getChat/{id}',[ApiProductController::class,'getChat']);


Route::post('/register', [ApiProductController::class, 'register'])->name('api.register');

Route::post('/login',[ApiProductController::class,'login'])->name('api.login');

Route::group(['middleware' => 'auth:api'], function(){

Route::get('/home',[ApiProductController::class,'home'] )->name('api.home');
});
