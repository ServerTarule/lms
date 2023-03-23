<?php

use App\Http\Controllers\ActionTypeController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ConditionsController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\DynamicMasterController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\MainMasterController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RulesController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CenterController;
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
    Route::get('/master', [MasterController::class, 'index'])->name('master')->middleware('can:read master');
    Route::post('/master', [MasterController::class, 'store'])->name('master')->middleware('can:create master');
    Route::get('/master/{id}', [MasterController::class, 'edit'])->name('master/{id}')->middleware('can:update master');
    Route::post('/master/{id}', [MasterController::class, 'update'])->name('master/{id}')->middleware('can:update master');

    // Main Master
    Route::get('/master/main/{id}', [MainMasterController::class, 'index'])->name('/master/main/{id}')->middleware('can:read master');
    Route::post('/master/main/{id}', [MainMasterController::class, 'store'])->name('/master/main/{id}')->middleware('can:create master');
    Route::get('/master/main/edit/{id}', [MainMasterController::class, 'remove'])->name('/master/main/edit/{id}')->middleware('can:delete master');

    // Dynamic Master
    Route::get('/dynamic/{id}', [DynamicMasterController::class, 'index'])->name('/dynamic/{id}')->middleware('can:read master');
    Route::post('/dynamic/{id}', [DynamicMasterController::class, 'store'])->name('/dynamic/{id}')->middleware('can:create master');
    Route::get('/dynamic/edit/{id}', [DynamicMasterController::class, 'edit'])->name('/dynamic/edit/{id}')->middleware('can:update master');
    Route::post('/dynamic/edit/{id}', [DynamicMasterController::class, 'update'])->name('/dynamic/edit/{id}')->middleware('can:update master');

    //Rules
    Route::get('/rules', [RulesController::class, 'index'])->name('rules.index')->middleware('can:read master');
    Route::get('/rules/create', [RulesController::class, 'create'])->name('rules.create')->middleware('can:read master');
    Route::post('/rules/store', [RulesController::class, 'store'])->name('rules.store')->middleware('can:read master');
//    Route::post('/rules/create', [RulesController::class, 'createrule'])->name('rules.create.post')->middleware('can:read master');

    //Conditions
    Route::get('/conditions/create', [ConditionsController::class, 'create'])->name('conditions.create')->middleware('can:read master');
    Route::post('/conditions/store', [ConditionsController::class, 'store'])->name('conditions.store')->middleware('can:read master');
//    Route::get('/rules/create/condition', [RulesController::class, 'createcondition'])->name('rules.create.condition')->middleware('can:read master');

    //Lead
    Route::get('/leads', [LeadController::class, 'index'])->name('leads.index')->middleware('can:read lead');
    Route::get('/leads/create', [LeadController::class, 'create'])->name('leads.create')->middleware('can:read lead');
    Route::post('/leads/store', [LeadController::class, 'store'])->name('leads.store')->middleware('can:read lead');

    Route::get('/leads/call', [LeadController::class, 'call'])->name('leads.call')->middleware('can:read lead');
    Route::get('/leadassignment', [LeadController::class, 'assignment'])->name('leads')->middleware('can:read lead');
    Route::get('/leadupload', [LeadController::class, 'upload'])->name('leads')->middleware('can:read lead');

    //State
    Route::get('/states', [StateController::class, 'index'])->name('states')->middleware('can:read lead');

    //City
    Route::get('/cities', [CityController::class, 'index'])->name('cities')->middleware('can:read lead');

    //Action Type
    Route::get('/actions', [ActionTypeController::class, 'index'])->name('actions')->middleware('can:read lead');
    //Doctors
    Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors');//->middleware('can:read doctor');
    Route::post('/addDoctors', [DoctorController::class, 'addDoctors'])->name('addDoctors');//->middleware('can:create doctor');

    // Centers
    Route::get('/centers', [CenterController::class, 'index'])->name('centers');//->middleware('can:read employee');
    Route::post('/addCenter', [CenterController::class, 'addCenter'])->name('addCenter');//->middleware('can:create doctor');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [CustomAuthController::class, 'logout'])->name('logout');
});


Route::get('/', [CustomAuthController::class, 'index'])->name('login');
Route::get('/login', [CustomAuthController::class, 'index']);
Route::post('/postlogin', [CustomAuthController::class, 'login']);
