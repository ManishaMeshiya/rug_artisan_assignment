<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\UserTransactionController;

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

Route::group(['middleware'=>['XSS','throttle:api'],'prefix'=>'v1'],function(){
        Route::post('user/signup',[UserController::class,'signup']);
        Route::post('user/login',[UserController::class,'login']);
        Auth::routes();
        Route::post('user/logout',[UserController::class,'logout']);
        Route::get('user/transaction-list',[UserTransactionController::class,'index']);
        Route::post('user/create-transaction',[UserTransactionController::class,'store']);
        Route::put('user/update-transaction/{id}',[UserTransactionController::class,'update']);
        //Only admin can access
        Route::group(['middleware'=>'user-access:1'],function(){
            Route::delete('user/delete-transaction/{id}',[UserTransactionController::class,'delete']);
        });
});


