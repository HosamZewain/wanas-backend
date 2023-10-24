<?php

use App\Http\Controllers\PlaygroundController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\ForgetPasswordController;

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

Route::get('reset-password/{token}', [ForgetPasswordController::class, 'showResetPasswordForm'])
    ->name('reset.password.get');

Route::post('reset-password', [ForgetPasswordController::class, 'submitResetPasswordForm'])
    ->name('reset.password.post');

 Route::get('/{any}', function () {
     return view('app');
 })->where('any', '.*')->name('vueApp');
 if (app()->environment('local')) {
     Route::get('/playground', PlaygroundController::class);
 }
