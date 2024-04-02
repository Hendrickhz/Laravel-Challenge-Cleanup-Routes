<?php

use App\Http\Controllers\Admin\AdminBookController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserChangePassword;
use App\Http\Controllers\UserSettingsController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', HomeController::class)->name('home');
Route::middleware('auth')->group(function () {
    Route::resource('book', BookController::class)->only('create', 'store')->names(['create' => 'books.create', 'store' => 'books.store']);
    Route::get('book/{book:slug}/report/create', [BookReportController::class, 'create'])->name('books.report.create');
    Route::post('book/{book}/report', [BookReportController::class, 'store'])->name('books.report.store');

    Route::prefix('users')->name('user.')->group(function () {
        Route::resource('books', BookController::class)->except('create', 'store', 'show')->scoped(['book' => 'slug'])->names(['index' => 'books.list']);


        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');

        Route::prefix('setting')->group(function () {
            Route::controller(UserSettingsController::class)->group(function () {
                Route::get('/', 'index')->name('settings');
                Route::post('/{user}', 'update')->name('settings.update');
            });
            Route::post('password/change/{user}', [UserChangePassword::class, 'update'])->name('password.update');
        });
    });
});
Route::get('book/{book:slug}', [BookController::class, 'show'])->name('books.show');


require __DIR__ . '/auth.php';
