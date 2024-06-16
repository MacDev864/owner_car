<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\car\CarController;
use Illuminate\Http\Request;
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
/*  ------------------------Authentication-------------------------------- */

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'mobilelogin']);
/*  ------------------------Authentication-------------------------------- */

Route::group([
    'prefix' => 'v1',
    'middleware' => 'verify.jwt.token'

], function ($router) {
    /*  ------------------------Vehicle-------------------------------- */
    Route::get('/get/type/vehicle', [CarController::class, 'getTypeVehicle']);

    Route::get('/get/profile', [CarController::class, 'getCarProfile']);
    Route::get('/get/profile/{vehicle_id}', [CarController::class, 'getCarProfileById']);
    Route::post('/create/profile', [CarController::class, 'create']);
    Route::post('/update/profile', [CarController::class, 'update']);
    Route::post('/delete/profile', [CarController::class, 'delete']);
    Route::post('/clear/profile', [CarController::class, 'clear']);
    /*  ------------------------Vehicle-------------------------------- */
});
