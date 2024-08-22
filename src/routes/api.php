<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\sensorsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceDataController;
use App\Http\Controllers\SensorDataController;
use App\Http\Controllers\maintenanceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


    // Route::resource('sensor-data', SensorDataController::class);
    // Route::resource('maintenances', maintenanceController::class);
    // Route::resource('sensors', sensorsController::class);
    // Route::resource('alerts', AlertController::class);
    //Route::apiResource('device-data', DeviceDataController::class);
	Route::match(['get', 'post'], '/device-data', [DeviceDataController::class, 'store']);
    Route::match(['get', 'post'], '/devicesettings', [DeviceDataController::class, 'getDeviceSettings']);

    //Graphana API's
    Route::match(['get', 'post'], '/devices/toggle-status/{device_id}', [DashboardController::class, 'toggleDeviceOnOffStatus']);
    Route::match(['get', 'post'], '/devices/toggle-mode/{device_id}', [DashboardController::class, 'toggleDeviceStatus']);
    Route::post('/setpoint/update/{Device_ID}', [DashboardController::class, 'updateSetpoint']);

    //Route::middleware(['auth'])->group(function () {

        Route::get('/dashboard',[DashboardController::class, 'getDashboardData']);
        Route::get('/filtered-data/{interval}', [DashboardController::class, 'getFilteredData']);
        Route::get('/check-online-status/{device_id}', [DashboardController::class, 'checkDeviceOnlineStatus']);
    //});

    Route::get('alerts/filter', [AlertController::class, 'filterByType']);

