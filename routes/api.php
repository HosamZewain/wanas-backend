<?php

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\LogoutController;
use App\Http\Controllers\Api\V1\CountryController;
use App\Http\Controllers\Api\V1\FileController;
use App\Http\Controllers\Api\V1\FilterController;
use App\Http\Controllers\Api\V1\GovernorateController;
use App\Http\Controllers\Api\V1\NotificationController;
use App\Http\Controllers\Api\V1\PageController;
use App\Http\Controllers\Api\V1\PermissionController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\VehiclesTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', LoginController::class);

Route::resource('files', FileController::class)->only(['store', 'destroy', 'show']);
Route::post('users/forget-password', [UserController::class, 'forgetPassword']);

Route::middleware(['auth:sanctum'])
    ->group(function () {

        //---------------- START: basics routes ----------------
        Route::post('logout', LogoutController::class);
        Route::get('/filters/{model}', FilterController::class);
        Route::apiResource('roles', RoleController::class);
        Route::get('permissions', PermissionController::class);
        Route::put('users/{user}/token', [UserController::class, 'updateToken']);

        Route::apiResource('notifications', NotificationController::class)->only(['index', 'destroy']);
        Route::controller(NotificationController::class)
            ->prefix('notifications')->group(function () {
                Route::put('{notification}/toggle-read', 'markAsRead');
                Route::post('{notification}/take-action', 'takeAction');
                Route::put('mark-all-as-read', 'markAllAsRead');
                Route::put('mark-all-as-unread', 'markAllAsUnread');
                Route::delete('delete-all', 'deleteAll');
            });
        //---------------- END: basics routes ----------------

        //---------------- START: vehcles types ----------------
        Route::apiResource('vehicles-types', VehiclesTypeController::class);
        //---------------- END: vehcles types ----------------

        //---------------- START: pages ----------------
        Route::apiResource('pages', PageController::class);
        //---------------- END: pages ----------------

        //---------------- START: governorates ----------------
        Route::apiResource('governorates', GovernorateController::class);
        //---------------- END: governorates ----------------

         //---------------- START: countries ----------------
         Route::apiResource('countries', CountryController::class);
         //---------------- END: countries ----------------

    });

