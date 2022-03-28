<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/otpForm',[\App\Http\Controllers\UserController::class,'otpForm'])->name('otpForm');
Route::post('/sendotp',[\App\Http\Controllers\UserController::class,'sendotp'])->name('sendotp');
Route::post('/sendwithotp',[\App\Http\Controllers\UserController::class,'sendWithotp'])->name('send.withotp');
