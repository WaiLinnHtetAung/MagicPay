<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


require __DIR__.'/auth.php';
require __DIR__.'/adminauth.php';

Route::group(['middleware' => ['auth']], function() {
    Route::get('/', [PageController::class, 'home'])->name('home');

    //home
    Route::get('/transfer', [PageController::class, 'transfer'])->name('transfer');
    Route::post('/transfer/confirm', [PageController::class, 'transferConfirm']);
    Route::get('/to-account-verify', [PageController::class, 'verifyAccount']);
    Route::post('/transfer/complete', [PageController::class, 'transferComplete']);
    Route::get('/password/check', [PageController::class, 'passwordCheck']);

    //transaction
    Route::get('/transaction', [PageController::class, 'transaction'])->name('transaction');
    Route::get('/transaction/{trx_id}', [PageController::class, 'transactionDetail']);

    //profile
    Route::get('/profile', [PageController::class, 'profile'])->name('profile');
    Route::get('/update-password', [PageController::class, 'updatePassword'])->name('update.password');
    Route::post('/update-password', [PageController::class, 'updatePasswordStore'])->name('update.password.store');

    //wallet
    Route::get('/wallet', [PageController::class, 'wallet'])->name('wallet');

    //receive QR
    Route::get('/receive-qr', [PageController::class, 'receiveQR'])->name('qr');
    Route::get('/download-qr', [PageController::class, 'downloadQR'])->name('download.qr');

    //scan QR
    Route::get('/scan-qr', [PageController::class, 'scanQR'])->name('scan');
    Route::get('/scan-and-pay-form', [PageController::class, 'scanAndPayForm'])->name('scan.pay.form');

    //notificaton
    Route::get('/notification', [NotificationController::class, 'index'])->name('noti.index');
    Route::get('/notification/{id}', [NotificationController::class, 'show'])->name('noti.show');

    //logout
    Route::get('/logout', [PageController::class, 'logout'])->name('user.logout');
});

