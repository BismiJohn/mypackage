<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\projectController;
use App\Http\Controllers\sensorsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DeviceDataController;
use App\Http\Controllers\SensorDataController;
use App\Http\Controllers\maintenanceController;
use App\Http\Controllers\ServiceTeamController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CustomerController;

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/device-data', [DashboardController::class, 'getDeviceData'])->name('dashboard.deviceData');
    Route::get('/dashboard/device-mode-data', [DashboardController::class, 'getDeviceModeData'])->name('dashboard.deviceModeData');
    Route::put('/devices/{id}', [DeviceDataController::class, 'update']);


    // Projects routes
    Route::get('/projects', [projectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [projectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [projectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project_id}', [projectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{project_id}/edit', [projectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project_id}', [projectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project_id}', [projectController::class, 'destroy'])->name('projects.destroy');
    Route::get('/projects/count', [projectController::class, 'count'])->name('projects.count');
    Route::resource('sensor-data', SensorDataController::class);
    Route::resource('maintenances', maintenanceController::class);
    Route::resource('sensor-data', SensorDataController::class);
    Route::resource('sensors', sensorsController::class);
    Route::get('/sensors/count', [SensorsController::class, 'count'])->name('sensors.count');

    Route::resource('alerts', AlertController::class);
    Route::get('/alerts/count', [AlertController::class, 'count'])->name('alerts.count');
    Route::resource('serviceteams', ServiceTeamController::class);
    Route::post('/serviceteams/store-ajax', [ServiceTeamController::class, 'storeAjax'])->name('serviceteams.storeAjax');
    Route::get('/test-alert', function () {
        session()->flash('alert', 'This is a test alert message.');
        return view('app');
    });
    Route::get('/api/alerts', [LogController::class, 'getAlerts'])->name('getAlerts');
    Route::match(['get', 'post'], '/device-settings', [DashboardController::class, 'updateDeviceSettings'])->name('settings.update');
    Route::match(['get', 'post'], '/device-settings-fetch', [DashboardController::class, 'fetchDeviceSettings'])->name('settingsform.update');
    Route::get('/fetch_calibration_dates/{sensor_id}', [sensorsController::class, 'getCalibrationDates'])->name('sensors.calibration_dates');
    Route::get('/calibration-dates/{id}', [sensorsController::class,'showCalibrationDate']);
    Route::put('/calibration-dates/{id}', [sensorsController::class,'updateCalibrationDate']);
    Route::delete('/calibration-dates/{id}', [sensorsController::class,'deleteCalibrationDate']);
    Route::resource('customers', CustomerController::class);
});
