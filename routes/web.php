<?php

use App\Http\Controllers\ActionTypeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\ConditionsController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\DynamicMasterController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\MainMasterController;
use App\Http\Controllers\OccasionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RulesController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\TemplateController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\MenusPermissionController;


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
    Route::post('/role/destroy', [RoleController::class, 'destroy'])->name('destroy')->middleware('can:read master');
    Route::get('/role/{id}', [RoleController::class, 'edit'])->name('role/{id}')->middleware('can:update role');
    Route::post('/createrole', [RoleController::class, 'store'])->name('createrole')->middleware('can:create role');
    Route::post('/updaterole', [RoleController::class, 'update'])->name('updaterole')->middleware('can:update role');
    Route::get('/assign', [RoleController::class, 'assign'])->name('assign')->middleware('can:assign role');
    Route::get('/assign-role', function () { return view('assignrole'); });

    Route::get('/createmaste', [RoleController::class, 'assign'])->name('assign')->middleware('can:assign role');
    Route::get('/master/{id}', [RoleController::class, 'assign'])->name('assign')->middleware('can:assign role');
    Route::get('/actiontype', [RoleController::class, 'assign'])->name('assign')->middleware('can:assign role');
    Route::get('/leadtype', [RoleController::class, 'assign'])->name('assign')->middleware('can:assign role');
    Route::get('/leadstatus', [RoleController::class, 'assign'])->name('assign')->middleware('can:assign role');
    Route::get('/state', [RoleController::class, 'assign'])->name('assign')->middleware('can:assign role');
    Route::get('/city', [RoleController::class, 'assign'])->name('assign')->middleware('can:assign role');

    //Permission
//    Route::get('/permission', [PermissionController::class, 'index'])->name('permission')->middleware('can:read role');
//    Route::get('/permission/{id}', [PermissionController::class, 'edit'])->name('permission/{id}')->middleware('can:update role');

    // Employee
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee')->middleware('can:read employee');
    Route::get('/addemployee', [EmployeeController::class, 'create'])->name('addemployee')->middleware('can:create employee');
    Route::post('/createemployee', [EmployeeController::class, 'store'])->name('createemployee')->middleware('can:create employee');
    Route::post('/updateemployee', [EmployeeController::class, 'update'])->name('updateemployee')->middleware('can:update employee');
    Route::get('/employee/{id}', [EmployeeController::class, 'edit'])->name('employee/{id}')->middleware('can:update employee');

    //Permissions
    Route::get('/employees/permissions', [PermissionsController::class, 'index'])->name('permissions.index')->middleware('can:read employee');
    Route::get('/employees/permissions/{id}', [PermissionsController::class, 'edit'])->name('permissions.edit')->middleware('can:read employee');
    Route::post('/employees/permissions/{id}', [PermissionsController::class, 'update'])->name('permissions.update')->middleware('can:read employee');
    Route::get('/employees/permissions/{id}/masters', [PermissionsController::class, 'masterindex'])->name('permissions.masterindex')->middleware('can:read employee');

    // Leave
    Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves.index')->middleware('can:read master');
    Route::post('/leaves/store', [LeaveController::class, 'store'])->name('leaves.store')->middleware('can:read master');
    Route::post('/leaves/destroy', [LeaveController::class, 'destroy'])->name('leaves.destroy')->middleware('can:read master');
    Route::get('/leaves/{id}', [LeaveController::class, 'view'])->name('leaves.view')->middleware('can:read master');
    Route::get('/leaves/calendar/{id}', [LeaveController::class, 'calendar'])->name('leaves.calendar')->middleware('can:read master');

//    Route::get('/addleave', [LeaveController::class, 'create'])->name('addleave')->middleware('can:create leaves');
//    Route::post('/createleave', [LeaveController::class, 'store'])->name('createleave')->middleware('can:create leaves');
//    Route::post('/updateleave', [LeaveController::class, 'update'])->name('updateleave')->middleware('can:update leaves');
//    Route::post('/leaves/{id}', [LeaveController::class, 'edit'])->name('leaves/{id}')->middleware('can:update leaves');

    // Designation
    Route::get('/designation', [DesignationController::class, 'index'])->name('designation')->middleware('can:read designation');
    Route::post('/designation', [DesignationController::class, 'store'])->name('designation')->middleware('can:create designation');
    Route::get('/designation/{id}', [DesignationController::class, 'edit'])->name('designation/{id}')->middleware('can:update designation');
    Route::post('/designation/{id}', [DesignationController::class, 'update'])->name('designation/{id}')->middleware('can:update designation');

    // Masters
    Route::get('/master', [MasterController::class, 'index'])->name('master')->middleware('can:read master');
    Route::post('/master', [MasterController::class, 'store'])->name('master')->middleware('can:create master');
    Route::post('/master/destroy', [MasterController::class, 'destroy'])->name('master.destroy')->middleware('can:read master');
    Route::get('/master/{id}', [MasterController::class, 'edit'])->name('master/{id}')->middleware('can:update master');
    Route::post('/master/{id}', [MasterController::class, 'update'])->name('master/{id}')->middleware('can:update master');

    // Main Master
    Route::post('/master/main/destroy', [MainMasterController::class, 'destroy'])->name('mainmaster.destroy')->middleware('can:read master');
    Route::get('/master/main/{id}', [MainMasterController::class, 'index'])->name('/master/main/{id}')->middleware('can:read master');
    Route::post('/master/main/{id}', [MainMasterController::class, 'store'])->name('/master/main/{id}')->middleware('can:create master');
    Route::post('/getcitiesBystate', [MainMasterController::class, 'getcitiesBystate'])->name('/getcitiesBystate')->middleware('can:create master');

    // Dynamic Master
    Route::post('/dynamic/destroy', [DynamicMasterController::class, 'destroy'])->name('dynamicmaster.destroy')->middleware('can:read master');
    Route::get('/dynamic/{id}', [DynamicMasterController::class, 'index'])->name('/dynamic/{id}')->middleware('can:read master');
    Route::post('/dynamic/{id}', [DynamicMasterController::class, 'store'])->name('/dynamic/{id}')->middleware('can:create master');
    Route::get('/dynamic/edit/{id}', [DynamicMasterController::class, 'edit'])->name('/dynamic/edit/{id}')->middleware('can:update master');
    Route::post('/dynamic/edit/{id}', [DynamicMasterController::class, 'update'])->name('/dynamic/edit/{id}')->middleware('can:update master');

    // Menu
    Route::get('/menus', [MenusController::class, 'index'])->name('menus')->middleware('can:read master');
    Route::post('/menus', [MenusController::class, 'store'])->name('menus')->middleware('can:create master');
    Route::get('/menus/{id}', [MenusController::class, 'edit'])->name('menus/{id}')->middleware('can:update master');
    Route::post('/menus/{id}', [MenusController::class, 'update'])->name('menus/{id}')->middleware('can:update master');
    Route::delete('menus/{id}', [MenusController::class, 'delete'])->name('menus.delete');

    // Menu Permission
    Route::get('/permissions/employee-list', [MenusPermissionController::class, 'index'])->name('menuspermission')->middleware('can:read master');
    Route::get('/permissions/menu-list/{employeeId}', [MenusPermissionController::class, 'managePermission'])->name('menuspermission')->middleware('can:read master');
    Route::post('/menus/set-all-permissions/{employeeId}', [MenusPermissionController::class, 'setPermission'])->name('menuspermission/{id}')->middleware('can:update master');
    Route::post('/menus/set-single-permissions/{employeeId}', [MenusPermissionController::class, 'setSinglePermission'])->name('menuspermission/{id}')->middleware('can:update master');
    Route::post('/menuspermission/{id}', [MenusPermissionController::class, 'update'])->name('menuspermission/{id}')->middleware('can:update master');
    Route::delete('menuspermission/{id}', [MenusPermissionController::class, 'delete'])->name('menuspermission.delete');


    // Main Master
    Route::get('/master/main/{id}', [MainMasterController::class, 'index'])->name('/master/main/{id}')->middleware('can:read master');
    Route::post('/master/main/{id}', [MainMasterController::class, 'store'])->name('/master/main/{id}')->middleware('can:create master');
    Route::get('/master/main/edit/{id}', [MainMasterController::class, 'remove'])->name('/master/main/edit/{id}')->middleware('can:delete master');
    Route::get('/master/main/edit-value/{masterid}/{id}', [MainMasterController::class, 'edit'])->name('/master/main/edit-value/{masterid}/{id}')->middleware('can:read master');
    Route::post('/master/main/update-value/{masterid}/{id}', [MainMasterController::class, 'update'])->name('/master/main/update-value/{masterid}/{id}')->middleware('can:update master');
    Route::delete('/master/main/remove/{id}', [MainMasterController::class, 'delete'])->name('mainmaster.delete');

    // Dynamic Master
    Route::get('/dynamic/{id}', [DynamicMasterController::class, 'index'])->name('/dynamic/{id}')->middleware('can:read master');
    Route::post('/dynamic/{id}', [DynamicMasterController::class, 'store'])->name('/dynamic/{id}')->middleware('can:create master');
    Route::get('/dynamic/edit/{id}', [DynamicMasterController::class, 'edit'])->name('/dynamic/edit/{id}')->middleware('can:update master');
    Route::post('/dynamic/edit/{id}', [DynamicMasterController::class, 'update'])->name('/dynamic/edit/{id}')->middleware('can:update master');

    //Locations
    Route::get('/locations', [LocationController::class, 'index'])->name('cities')->middleware('can:read lead');

    //Doctors
    Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors');//->middleware('can:read master');
    Route::post('/doctors/destroy', [DoctorController::class, 'destroy'])->name('doctors.destroy')->middleware('can:read master');
    Route::post('/addDoctors', [DoctorController::class, 'addDoctors'])->name('addDoctors');//->middleware('can:read master');

    //Centers
    Route::get('/centers', [CenterController::class, 'index'])->name('centers')->middleware('can:read master');
    Route::post('/centers/addCenter', [CenterController::class, 'addCenter'])->name('addCenter')->middleware('can:read master');
    Route::post('/centers/destroy', [CenterController::class, 'destroy'])->name('centers.destroy')->middleware('can:read master');
    Route::post('/centers/edit', [CenterController::class, 'edit'])->name('centers.edit')->middleware('can:read master');
    Route::post('/centers/checkdoctors/{isEdit}', [CenterController::class, 'checkdoctors'])->name('centers.checkdoctors')->middleware('can:read master');
    Route::post('/centers/updateCenter/{id}', [CenterController::class, 'updateCenter'])->name('updateCenter')->middleware('can:read master');

    //Templates
    Route::get('/templates', [TemplateController::class, 'index'])->name('templates.index')->middleware('can:read master');
    Route::post('/templates/store', [TemplateController::class, 'store'])->name('templates.store')->middleware('can:read master');
    Route::post('/templates/destroy', [TemplateController::class, 'destroy'])->name('templates.destroy')->middleware('can:read master');

    //Holidays
    Route::get('/holidays', [HolidayController::class, 'index'])->name('holidays.index')->middleware('can:read master');
    Route::post('/holidays/store', [HolidayController::class, 'store'])->name('holidays.store')->middleware('can:read master');
    Route::post('/holidays/destroy', [HolidayController::class, 'destroy'])->name('holidays.destroy')->middleware('can:read master');

    //Rules
    Route::get('/rules', [RulesController::class, 'index'])->name('rules.index')->middleware('can:read master');
    Route::get('/rules/create', [RulesController::class, 'create'])->name('rules.create')->middleware('can:read master');
    Route::post('/rules/store', [RulesController::class, 'store'])->name('rules.store')->middleware('can:read master');
    Route::post('/rules/update', [RulesController::class, 'update'])->name('rules.update')->middleware('can:read master');
    Route::get('/rules/{id}', [RulesController::class, 'edit'])->name('rules.edit')->middleware('can:read master');

    //Conditions
    Route::get('/conditions/create', [ConditionsController::class, 'create'])->name('conditions.create')->middleware('can:read master');
    Route::get('/conditions/edit', [ConditionsController::class, 'edit'])->name('conditions.edit')->middleware('can:read master');
    Route::post('/conditions/store', [ConditionsController::class, 'store'])->name('conditions.store')->middleware('can:read master');
    Route::post('/conditions/update', [ConditionsController::class, 'update'])->name('conditions.update')->middleware('can:read master');
    Route::post('/conditions/destroy', [ConditionsController::class, 'destroy'])->name('conditions.destroy')->middleware('can:read master');

    //Leads
    Route::get('/leads', [LeadController::class, 'index'])->name('leads.index')->middleware('can:read master');
    Route::get('/leads/show/{id}', [LeadController::class, 'show'])->name('leads.show')->middleware('can:read master');
    Route::get('/leads/create', [LeadController::class, 'create'])->name('leads.create')->middleware('can:read master');
    Route::post('/leads/store', [LeadController::class, 'store'])->name('leads.store')->middleware('can:read master');
    Route::post('/leads/update', [LeadController::class, 'updateone'])->name('leads.updateone')->middleware('can:read master');


    Route::get('/leads/calls', [LeadController::class, 'call'])->name('leads.call')->middleware('can:read master');
    Route::get('/leads/calls/{id}', [LeadController::class, 'showcall'])->name('leads.showcall')->middleware('can:read master');
    Route::post('/leads/calls/{id}', [LeadController::class, 'update'])->name('leads.update')->middleware('can:read master');
    Route::post('/leads/calls/{id}/email', [LeadController::class, 'email'])->name('leads.email')->middleware('can:read master');
    Route::post('/leads/calls/{id}/whatsapp', [LeadController::class, 'whatsapp'])->name('leads.whatsapp')->middleware('can:read master');
    Route::post('/leads/calls/{id}/call', [LeadController::class, 'leadcall'])->name('leads.leadcall')->middleware('can:read master');
    Route::get('/leads/followup', [LeadController::class, 'followup'])->name('leads.followup')->middleware('can:read master');
    Route::post('/leads/upload', [LeadController::class, 'upload'])->name('leads.upload')->middleware('can:read master');
    Route::get('/leads/export', [LeadController::class, 'export'])->name('leads.export')->middleware('can:read master');
//    Route::get('/leadassignment', [LeadController::class, 'assignment'])->name('leads')->middleware('can:read lead');
    Route::get('/leads/{id}', [LeadController::class, 'showtoedit'])->name('leads.showtoedit')->middleware('can:read master');

    //Communications
    Route::get('/communications', [CommunicationController::class, 'index'])->name('communications.index')->middleware('can:read master');
    Route::post('/communications/store', [CommunicationController::class, 'store'])->name('communications.store')->middleware('can:read master');
    Route::post('/communications/update', [CommunicationController::class, 'update'])->name('communications.update')->middleware('can:read master');
    Route::post('/communications/destroy', [CommunicationController::class, 'destroy'])->name('communications.destroy')->middleware('can:read master');
    Route::get('/communications/templates/{id}', [CommunicationController::class, 'templates'])->name('/communications/templates/{id}')->middleware('can:read master');
    Route::get('/communications/{id}', [CommunicationController::class, 'show'])->name('communications.show')->middleware('can:read master');
    Route::get('/communications/{id}/leads', [CommunicationController::class, 'leads'])->name('/communications/{id}/leads')->middleware('can:read master');

    //Other Management
    Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index')->middleware('can:read master');
    Route::get('/quotes', [QuoteController::class, 'index'])->name('quotes.index')->middleware('can:read master');
    Route::get('/occasions', [OccasionController::class, 'index'])->name('occasions.index')->middleware('can:read master');

    //Logs
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index')->middleware('can:read master');
    Route::get('/logs/leads/{$id}', [LogController::class, 'leadslogs'])->name('logs.leadslogs')->middleware('can:read master');


    //State
    Route::get('/states', [StateController::class, 'index'])->name('states')->middleware('can:read lead');

    //City
    Route::get('/cities', [CityController::class, 'index'])->name('cities')->middleware('can:read lead');

    //Action Type
    Route::get('/actions', [ActionTypeController::class, 'index'])->name('actions')->middleware('can:read lead');



    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [CustomAuthController::class, 'logout'])->name('logout');

    // Template Master


});


Route::get('/', [CustomAuthController::class, 'index'])->name('login');
Route::get('/login', [CustomAuthController::class, 'index']);
Route::post('/postlogin', [CustomAuthController::class, 'login']);
