<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Auth;
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

Route::get('transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
Route::get('transactions/{category:slug?}', [TransactionController::class, 'index'])->name('transactions.index');
Route::post('transactions/', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
Route::put('transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
