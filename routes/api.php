<?php

use App\Http\Middleware\checkUserStatus;
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
/*test*/
Route::get('doSomeStuff', [\App\Http\Controllers\Api\HomeController::class, 'doSomeStuff']);

//login & register
Route::get('/', [\App\Http\Controllers\Api\HomeController::class, 'index']);
Route::post('register', [\App\Http\Controllers\Api\Auth\RegisterController::class, 'register']);
Route::post('login', [\App\Http\Controllers\Api\Auth\LoginController::class, 'login']);
Route::post('/update_password', [\App\Http\Controllers\Api\Auth\LoginController::class, 'updatePassword']);

//dynamic modules
Route::get('vehicle_types', [\App\Http\Controllers\Api\HomeController::class, 'VehicleTypes']);
Route::get('trip_filters', [\App\Http\Controllers\Api\HomeController::class, 'tripFilters']);
Route::post('/contact_us', [\App\Http\Controllers\Api\HomeController::class, 'contactUs']);
Route::get('/pages', [\App\Http\Controllers\Api\HomeController::class, 'pages']);
Route::get('/page/{id}', [\App\Http\Controllers\Api\HomeController::class, 'page']);
Route::get('/terms_conditions', [\App\Http\Controllers\Api\HomeController::class, 'termsConditions']);
Route::get('/setting', [\App\Http\Controllers\Api\HomeController::class, 'setting']);
Route::get('/countries', [\App\Http\Controllers\Api\HomeController::class, 'countries']);
Route::get('/colors', [\App\Http\Controllers\Api\HomeController::class, 'colors']);
Route::get('/cities', [\App\Http\Controllers\Api\HomeController::class, 'cities']);
Route::get('/governorates', [\App\Http\Controllers\Api\HomeController::class, 'governorates']);
Route::get('refresh', [\App\Http\Controllers\Api\HomeController::class, 'refresh']);

//auth
Route::middleware(['checkUserStatus', 'auth:sanctum'])->group(function () {
    Route::post('logout', [\App\Http\Controllers\Api\Auth\LoginController::class, 'logout']);
    Route::post('user', [\App\Http\Controllers\Api\UserController::class, 'userDetails']);
    Route::post('activate_account', [\App\Http\Controllers\Api\Auth\RegisterController::class, 'activateAccount']);
    Route::post('/profile', [\App\Http\Controllers\Api\Auth\LoginController::class, 'profile']);
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
    Route::post('/rate_user', [\App\Http\Controllers\Api\UserController::class, 'rateUser']);
    Route::post('/add_city', [\App\Http\Controllers\Api\HomeController::class, 'addCity']);
});
