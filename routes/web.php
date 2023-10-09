<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    return view('payment');
});
Route::post('/create-payment', [\App\Http\Controllers\paymentController::class,'create'])->name('create');
Route::post('/store-payment', [\App\Http\Controllers\paymentController::class,'payment'])->name('payment');

