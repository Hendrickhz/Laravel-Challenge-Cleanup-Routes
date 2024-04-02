<?php

use App\Http\Controllers\Admin\AdminBookController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUsersController;
use Illuminate\Support\Facades\Route;


    Route::get('/', AdminDashboardController::class)->name('index');

    Route::put('book/approve/{book}', [AdminBookController::class, 'approveBook'])->name('books.approve');
    Route::resource('books', AdminBookController::class);

    Route::resource('users', AdminUsersController::class)->except(['store', 'create']);
