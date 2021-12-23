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
    return redirect()->to(url('admin'));
});

Auth::routes();


Route::middleware(['auth:web'])->prefix('admin')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class);
    Route::resource('user_vehicles', \App\Http\Controllers\Admin\UserVehicleController::class);
    Route::resource('trips', \App\Http\Controllers\Admin\TripController::class);
    Route::resource('pages', \App\Http\Controllers\Admin\pageController::class);
    Route::resource('settings', \App\Http\Controllers\Admin\SettingController::class);
    Route::resource('vehicles_types', \App\Http\Controllers\Admin\VehicleTypeController::class);
    Route::resource('contact_us', \App\Http\Controllers\Admin\ContactUsController::class);


    /**********ajax routes*/
    Route::get('customers_confirm/{id}', [\App\Http\Controllers\Admin\CustomerController::class, 'confirmForm'])->name('customers.confirmForm');
    Route::POST('customers_confirm', [\App\Http\Controllers\Admin\CustomerController::class, 'confirm'])->name('customers.confirm');
    Route::get('vehicles_confirm/{id}', [\App\Http\Controllers\Admin\UserVehicleController::class, 'confirmForm'])->name('user_vehicles.confirmForm');
    Route::POST('user_vehicles_confirm', [\App\Http\Controllers\Admin\UserVehicleController::class, 'confirm'])->name('user_vehicles.confirm');
});
