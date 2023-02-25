<?php

use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\DynamicController;
use App\Http\Controllers\DynamicValueController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/role', function () {
    return view('role');
});
Route::get('/permission', function () {
    return view('permission');
});


// Route::get('/', function () {
//     return view('login');
// });

Route::middleware(['auth'])->group(function () {
    // Roles
    Route::get('/role', [RoleController::class, 'index'])->name('role')->middleware('can:read role');
    Route::get('/role/{id}', [RoleController::class, 'edit'])->name('role/{id}')->middleware('can:update role');
    Route::post('/createrole', [RoleController::class, 'store'])->name('createrole')->middleware('can:create role');
    Route::post('/updaterole', [RoleController::class, 'update'])->name('updaterole')->middleware('can:update role');
    Route::get('/assign', [RoleController::class, 'assign'])->name('assign')->middleware('can:assign role');
    Route::get('/assign-role', function () {
        return view('assignrole');
    });

    Route::get('/createmaste', [RoleController::class, 'assign'])->name('assign')->middleware('can:assign role');
    Route::get('/master/{id}', [RoleController::class, 'assign'])->name('assign')->middleware('can:assign role');
    Route::get('/actiontype', [RoleController::class, 'assign'])->name('assign')->middleware('can:assign role');
    Route::get('/leadtype', [RoleController::class, 'assign'])->name('assign')->middleware('can:assign role');
    Route::get('/leadstatus', [RoleController::class, 'assign'])->name('assign')->middleware('can:assign role');
    Route::get('/state', [RoleController::class, 'assign'])->name('assign')->middleware('can:assign role');
    Route::get('/city', [RoleController::class, 'assign'])->name('assign')->middleware('can:assign role');


    //Permission
    Route::get('/permission', [PermissionController::class, 'index'])->name('permission')->middleware('can:read role');
    Route::get('/permission/{id}', [PermissionController::class, 'edit'])->name('permission/{id}')->middleware('can:update role');

    // Employee
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee')->middleware('can:read employee');
    Route::get('/addemployee', [EmployeeController::class, 'create'])->name('addemployee')->middleware('can:create employee');
    Route::post('/createemployee', [EmployeeController::class, 'store'])->name('createemployee')->middleware('can:create employee');
    Route::post('/updateemployee', [EmployeeController::class, 'update'])->name('updateemployee')->middleware('can:update employee');
    Route::get('/employee/{id}', [EmployeeController::class, 'edit'])->name('employee/{id}')->middleware('can:update employee');

    // Leave
    Route::get('/leave', [LeaveController::class, 'index'])->name('leave')->middleware('can:read leave');
    Route::get('/addleave', [LeaveController::class, 'create'])->name('addleave')->middleware('can:create leave');
    Route::post('/createleave', [LeaveController::class, 'store'])->name('createleave')->middleware('can:create leave');
    Route::post('/updateleave', [LeaveController::class, 'update'])->name('updateleave')->middleware('can:update leave');
    Route::post('/leave/{id}', [LeaveController::class, 'edit'])->name('leave/{id}')->middleware('can:update leave');

    // Designation
    Route::get('/designation', [DesignationController::class, 'index'])->name('designation')->middleware('can:read designation');
    Route::post('/designation', [DesignationController::class, 'store'])->name('designation')->middleware('can:create designation');
    Route::get('/designation/{id}', [DesignationController::class, 'edit'])->name('designation/{id}')->middleware('can:update designation');
    Route::post('/designation/{id}', [DesignationController::class, 'update'])->name('designation/{id}')->middleware('can:update designation');

    // Masters
    Route::get('/master', [DynamicController::class, 'index'])->name('master')->middleware('can:read master');
    Route::post('/master', [DynamicController::class, 'store'])->name('master')->middleware('can:create master');
    Route::get('/master/{id}', [DynamicController::class, 'edit'])->name('master/{id}')->middleware('can:update master');
    Route::post('/master/{id}', [DynamicController::class, 'update'])->name('master/{id}')->middleware('can:update master');

    // Masters value
    Route::get('/dynamic/{id}', [DynamicValueController::class, 'index'])->name('/dynamic/{id}')->middleware('can:read master');
    Route::post('/dynamic/{id}', [DynamicValueController::class, 'store'])->name('/dynamic/{id}')->middleware('can:create master');
    Route::get('/dynamic/edit/{id}', [DynamicValueController::class, 'edit'])->name('/dynamic/edit/{id}')->middleware('can:update master');
    Route::post('/dynamic/edit/{id}', [DynamicValueController::class, 'update'])->name('/dynamic/edit/{id}')->middleware('can:update master');

    // Masters Main
    Route::get('/master/main/{id}', [MasterController::class, 'index'])->name('/master/main/{id}')->middleware('can:read master');
    Route::post('/master/main/{id}', [MasterController::class, 'store'])->name('/master/main/{id}')->middleware('can:create master');
    Route::get('/master/main/edit/{id}', [MasterController::class, 'remove'])->name('/master/main/edit/{id}')->middleware('can:delete master');




    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [CustomAuthController::class, 'logout'])->name('logout');
});


Route::get('/', [CustomAuthController::class, 'index'])->name('login');
Route::get('/login', [CustomAuthController::class, 'index']);
Route::post('/postlogin', [CustomAuthController::class, 'login']);
