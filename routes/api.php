<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\DynamicMainController;
use App\Http\Controllers\DynamicValueController;
use App\Http\Controllers\EmployeeController;
use App\Models\LeaveManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::resource('/designation', DesignationController::class);
    Route::resource('/employee', EmployeeController::class);
    Route::resource('/leave', LeaveManagement::class);
    Route::resource('/master/main', DynamicMainController::class);
    Route::resource('/master/value', DynamicValueController::class);
});
