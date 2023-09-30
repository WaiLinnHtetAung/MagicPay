<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\WalletController;
use App\Http\Controllers\Backend\AdminUserController;


Route::group(['middleware' => ['auth:admin_user'], 'prefix' => 'admin', 'as' => 'admin.'], function() {
    Route::get('/', [PageController::class, 'index'])->name('home');

    //admin-user
    Route::resource('admin-users', AdminUserController::class);
    //admin-user datatable
    Route::get('admin-users/datatable/ssd', [AdminUserController::class, 'ssd']);

    //users
    Route::resource('users', UserController::class);
    //users datatable
    Route::get('users/datatable/ssd', [UserController::class, 'ssd']);

    //wallet
    Route::get('wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::get('wallet/datatable/ssd', [WalletController::class, 'ssd']);
});
