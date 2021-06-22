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
Route::post('logout', [\App\Http\Controllers\Api\Auth\LoginController::class, 'logout']);

//dynamic modules
Route::get('vehicle_types', [\App\Http\Controllers\Api\HomeController::class, 'VehicleTypes']);
Route::get('trip_filters', [\App\Http\Controllers\Api\HomeController::class, 'tripFilters']);
Route::post('/contact_us', [\App\Http\Controllers\Api\HomeController::class, 'contactUs']);
//auth
Route::middleware('auth:sanctum')->group(function () {
    Route::post('activate_account', [\App\Http\Controllers\Api\Auth\RegisterController::class, 'activateAccount']);
    Route::post('/profile', [\App\Http\Controllers\Api\Auth\LoginController::class, 'profile']);
    Route::post('/update_password', [\App\Http\Controllers\Api\Auth\LoginController::class, 'updatePassword']);
    Route::post('/add_vehicle', [\App\Http\Controllers\Api\VehicleController::class, 'addVehicle']);
    Route::post('/edit_vehicle', [\App\Http\Controllers\Api\VehicleController::class, 'editVehicle']);
    Route::post('/create_trip', [\App\Http\Controllers\Api\TripController::class, 'createTrip']);
    Route::post('/trips_list', [\App\Http\Controllers\Api\TripController::class, 'tripsList']);
    Route::post('/book_trip', [\App\Http\Controllers\Api\TripController::class, 'bookTrip']);
    Route::post('/trip_details', [\App\Http\Controllers\Api\TripController::class, 'tripDetails']);
    Route::post('/notification_list', [\App\Http\Controllers\Api\NotificationsController::class, 'notificationList']);
    Route::post('/accept_member', [\App\Http\Controllers\Api\TripController::class, 'acceptMember']);
    Route::post('/reject_member', [\App\Http\Controllers\Api\TripController::class, 'rejectMember']);
    Route::post('/rate_trip', [\App\Http\Controllers\Api\TripController::class, 'rateTrip']);
});
