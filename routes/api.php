<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'v1'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [PageController::class, 'profile']);

        Route::get('/transaction', [PageController::class, 'transaction']);
        Route::get('/transaction/{transaction:trx_id}', [PageController::class, 'transactionDetail']);

        //noti
        Route::get('notification', [PageController::class, 'notification']);
        Route::get('notification/{id}', [PageController::class, 'notificationDetail']);

        Route::get('verify/account', [PageController::class, 'verifyAccount']);
        Route::get('transfer/confirm', [PageController::class, 'transferConfirm']);
        Route::post('transfer/complete', [PageController::class, 'transferComplete']);
    });
});
