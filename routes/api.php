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
Route::get('/apiproductupdate/{id}',[ApiProductController::class,'updatebyid']);
