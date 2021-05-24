<?php

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

//login & register
Route::get('/', [\App\Http\Controllers\Api\HomeController::class, 'index']);
Route::post('register', [\App\Http\Controllers\Api\Auth\RegisterController::class, 'register']);
Route::post('login', [\App\Http\Controllers\Api\Auth\LoginController::class, 'login']);

//dynamic modules
Route::get('vehicle_types', [\App\Http\Controllers\Api\HomeController::class, 'VehicleTypes']);


//auth
Route::middleware('auth:sanctum')->group(function () {
    Route::post('activate_account', [\App\Http\Controllers\Api\Auth\RegisterController::class, 'activateAccount']);
    Route::post('/profile', [\App\Http\Controllers\Api\Auth\LoginController::class, 'profile']);
    Route::post('/add_vehicle', [\App\Http\Controllers\Api\VehicleController::class, 'addVehicle']);
    Route::post('/edit_vehicle', [\App\Http\Controllers\Api\VehicleController::class, 'editVehicle']);
});
