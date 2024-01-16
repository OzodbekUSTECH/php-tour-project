<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DayController;
use App\Http\Controllers\API\HotelController;
use App\Http\Controllers\API\TourController;

use App\Http\Controllers\API\TypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is wheretrue;can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(['prefix' => '{language}'], function () {
    Route::apiResource('hotels', HotelController::class);
    Route::apiResource('tours', TourController::class);
    Route::apiResource('days', DayController::class)->only(['index']);
    Route::apiResource('types', TypeController::class);
    // Добавьте здесь другие маршруты, если необходимо
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('login',[AuthController::class,'login']);
Route::post('register',[AuthController::class,'register']);



#this for protecting routers
// Route::group(['middleware' => 'auth:sanctum'],function(){
//     // Route::get('user',[AuthController::class,'userDetails']);
//     // Route::get('logout',[AuthController::class,'logout']);
// });
