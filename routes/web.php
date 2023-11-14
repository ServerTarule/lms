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
use App\Http\Controllers\UserController;
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
// Route::get('/permission', function () {
//     return view('permission');
// });


// Route::get('/', function () {
//     return view('login');
// });


//Login Related (Routes Working Without Authentication)
Route::get('/', [CustomAuthController::class, 'index'])->name('login');
Route::get('/login', [CustomAuthController::class, 'index']);
Route::post('/postlogin', [CustomAuthController::class, 'login']);

Route::middleware(['auth'])->group(function () {

    // NOt Functional Even ON QA
    Route::get('/leadstatus', [RoleController::class, 'assign'])->name('assign');//->middleware('can:assign role');//NOT DONE YET Because  Page Not Working
    Route::get('/logs/leads/{$id}', [LogController::class, 'leadlogs'])->name('logs.leadslogs');//->middleware('can:read master');
   
    
    //leadupload  (Menu Exists but ROute does not exists)
    //NO AUTHORIZATION CHECK ROUTES
    Route::post('/centers/checkdoctors/{isEdit}', [CenterController::class, 'checkdoctors'])->name('centers.checkdoctors');
    Route::post('/getcitiesBystate', [MainMasterController::class, 'getcitiesBystate'])->name('/getcitiesBystate');
    Route::post('/centers/getCenterByLocation', [CenterController::class, 'getCenterWithRespetToStateAndCity'])->name('getCenterWithRespetToStateAndCity');
    Route::get('/leads/updateleaddate/{id}/{d}/{m}/{y}/{f}', [LeadController::class, 'updateleaddate'])->name('leads.updateleaddate'); 
    Route::post('/getDependentMaster', [MainMasterController::class, 'getDependentMaster'])->name('/getDependentMaster');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [CustomAuthController::class, 'logout'])->name('logout');
    Route::get('/communications/templates/{id}', [CommunicationController::class, 'templates'])->name('/communications/templates/{id}');
    Route::get('/communications/{id}', [CommunicationController::class, 'show'])->name('communications.show');
    Route::get('/communications/getDayCount/{ruleId}', [CommunicationController::class, 'getDayCountForFrequency']);
    //Done With Checking Permissions
    Route::get('/menus', [MenusController::class, 'index'])->name('menus')->middleware('check_page_permission: /menus,view_permission');
    Route::post('/menus', [MenusController::class, 'store'])->name('menus')->middleware('check_page_permission: /menus,add_permission');
    Route::get('/menus/{id}', [MenusController::class, 'edit'])->name('menus/{id}')->middleware('check_page_permission: /menus,edit_permission');
    Route::post('/menus/{id}', [MenusController::class, 'update'])->name('menus/{id}')->middleware('check_page_permission: /menus,edit_permission');
    Route::post('menus/delete/{id}', [MenusController::class, 'delete'])->name('menus.delete')->middleware('check_page_permission: /menus,delete_permission');
    // Route::post('menus/deactivate/{id}', [MenusController::class, 'deactivate'])->name('menus.deactivate')->middleware('check_page_permission: /menus,delete_permission');
    Route::post('/menus/togglemenutatus/{id}', [MenusController::class, 'togglemenutatus'])->name('togglemenutatus')->middleware('check_page_permission:/menus,delete_permission,0');//->middleware('can:update employee'); //NOT YET CHECKED AS IT IS NOT WORKING


    Route::get('/addmenuurls', [MenusController::class, 'addmenuurls'])->name('menus.addmenuurls');
    //Master Main Menus & Dynamic Masters Routes
    Route::get('/master', [MasterController::class, 'index'])->name('master-list')->middleware('check_page_permission:/master,view_permission,0');
    Route::post('/master', [MasterController::class, 'store'])->name('master-add')->middleware('check_page_permission:/master,add_permission,0');
    Route::post('/master/destroy', [MasterController::class, 'destroy'])->name('master-delete')->middleware('check_page_permission:/master,delete_permission,1');
    Route::get('/master/edit/{id}', [MasterController::class, 'edit'])->name('master-edit')->middleware('check_page_permission:/master,edit_permission,0');
    Route::post('/master/{id}', [MasterController::class, 'update'])->name('master-update')->middleware('check_page_permission:/master,edit_permission,0');
    Route::get('/master/main/{id}', [MainMasterController::class, 'index'])->name('/master/main/{id}')->middleware('check_page_permission:/master,view_permission,0, 1');
    Route::post('/master/main/{id}', [MainMasterController::class, 'store'])->name('/master/main/{id}')->middleware('check_page_permission:/master,add_permission,0, 1');//->middleware('can:create master');
    Route::get('/dynamic/{id}', [DynamicMasterController::class, 'index'])->name('/dynamic/{id}')->middleware('check_page_permission:/master,view_permission,0, 1');//->middleware('can:read master');
    // Route::post('/dynamic/{id}', [DynamicMasterController::class, 'store'])->name('/dynamic/{id}')->middleware('check_page_permission:/master/main/{id},add_permission,0, 1');
    Route::post('/dynamic/{id}', [DynamicMasterController::class, 'addDynamicMaster'])->name('addDynamicMaster')->middleware('check_page_permission:/master/main/{id},add_permission,0, 2');
    // Route::get('/master/main/edit-value/{masterid}/{id}', [MainMasterController::class, 'edit'])->name('/master/main/edit-value/{masterid}/{id}')->middleware('check_page_permission:/master,edit_permission,0, 1');//->middleware('can:read master');
    Route::get('/master/main/edit-value/{masterid}/{id}', [MainMasterController::class, 'editMainMasterValue'])->name('/master/main/edit-value/{masterid}/{id}')->middleware('check_page_permission:/master,edit_permission,0, 2');
    // Route::post('/master/main/update-value/{masterid}/{id}', [MainMasterController::class, 'update'])->name('/master/main/update-value/{masterid}/{id}')->middleware('check_page_permission:/master,edit_permission,0, 1');//->middleware('can:update master');
    Route::post('/master/main/update-value/{masterid}/{id}', [MainMasterController::class, 'saveMainMasterUpdatedValue'])->name('/master/main/update-value/{masterid}/{id}')->middleware('check_page_permission:/master,edit_permission,0, 2');
    // Route::post('/master/main/destroy', [MainMasterController::class, 'destroy'])->name('mainmaster.destroy')->middleware('can:read master');
    Route::post('/master/main/destroy/{masterid}/{id}', [MainMasterController::class, 'deleteMainMasterValue'])->name('mainmaster.destroy')->middleware('check_page_permission:/master,delete_permission,0, 2');;
    //Doctors Routes
    Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors')->middleware('check_page_permission:/doctors,view_permission,0, 1');//->middleware('can:read master');
    Route::post('/doctors', [DoctorController::class, 'addDoctors'])->name('doctors.addDoctors')->middleware('check_page_permission:/doctors,add_permission,0, 1');//->middleware('can:read master');
    Route::post('/doctors/edit', [DoctorController::class, 'edit'])->name('edit')->middleware('check_page_permission:/doctors,edit_permission,0, 0');//->middleware('can:read master');
    Route::post('/doctors/update/{id}', [DoctorController::class, 'updateDoctor'])->name('updateDoctor')->middleware('check_page_permission:/doctors,edit_permission,0, 0');//->middleware('can:read master');
    Route::post('/doctors/destroy', [DoctorController::class, 'destroy'])->name('doctors.destroy')->middleware('check_page_permission:/doctors,delete_permission,0, 0');//->middleware('can:read master');
    //Centers Routes
    Route::get('/centers', [CenterController::class, 'index'])->name('centers')->middleware('check_page_permission:/centers,view_permission,0, 0');//->middleware('can:read master');
    Route::post('/centers/addCenter', [CenterController::class, 'addCenter'])->name('addCenter')->middleware('check_page_permission:/centers,add_permission,0');
    Route::post('/centers/edit', [CenterController::class, 'edit'])->name('centers.edit')->middleware('check_page_permission:/centers,edit_permission,0');//->middleware('can:read master');
    Route::post('/centers/updateCenter/{id}', [CenterController::class, 'updateCenter'])->name('updateCenter')->middleware('check_page_permission:/centers,edit_permission,0');//->middleware('can:read master');
    Route::post('/centers/destroy', [CenterController::class, 'destroy'])->name('centers.destroy')->middleware('check_page_permission:/centers,delete_permission,0');//->middleware('can:read master');
    //Templates
    Route::get('/templates', [TemplateController::class, 'index'])->name('templates.index')->middleware('check_page_permission:/templates,view_permission,0');//->middleware('can:read master');
    Route::post('/templates/store', [TemplateController::class, 'store'])->name('templates.store')->middleware('check_page_permission:/templates,add_permission,0');//->middleware('can:read master');
    Route::post('/templates/edit', [TemplateController::class, 'edit'])->name('edit')->middleware('check_page_permission:/templates,edit_permission,0');//->middleware('can:read master');
    Route::post('/templates/update/{id}', [TemplateController::class, 'updateTemplate'])->name('templates.updateTemplate')->middleware('check_page_permission:/templates,edit_permission,0');//;
    Route::post('/templates/destroy', [TemplateController::class, 'destroy'])->name('templates.destroy')->middleware('check_page_permission:/templates,delete_permission,0');//->middleware('can:read master');
    //Holidays
    Route::get('/holidays', [HolidayController::class, 'index'])->name('holidays.index')->middleware('check_page_permission:/holidays,view_permission,0');//->middleware('can:read master');
    Route::post('/holidays/store', [HolidayController::class, 'store'])->name('holidays.store')->middleware('check_page_permission:/holidays,add_permission,0');//->middleware('can:read master');
    Route::post('/holidays/edit', [HolidayController::class, 'edit'])->name('edit')->middleware('check_page_permission:/holidays,edit_permission,0');//->middleware('can:read master');
    Route::post('/holidays/update/{id}', [HolidayController::class, 'updateHoliday'])->name('holidays.updateHoliday')->middleware('check_page_permission:/holidays,edit_permission,0');
    Route::post('/holidays/destroy', [HolidayController::class, 'destroy'])->name('holidays.destroy')->middleware('check_page_permission:/holidays,delete_permission,0');//->middleware('can:read master');
    //Rules & Condition
    Route::get('/rules', [RulesController::class, 'index'])->name('rules.index')->middleware('check_page_permission:/rules,view_permission,0');//->middleware('can:read master');
    Route::get('/rules/create', [RulesController::class, 'create'])->name('rules.create')->middleware('check_page_permission:/rules,add_permission,0');//->middleware('can:read master');
    Route::post('/rules/store', [RulesController::class, 'store'])->name('rules.store')->middleware('check_page_permission:/rules,add_permission,0');//->middleware('can:read master');
    Route::post('/rules/update', [RulesController::class, 'update'])->name('rules.update')->middleware('check_page_permission:/rules,edit_permission,0');//->middleware('can:read master');
    Route::get('/rules/{id}', [RulesController::class, 'edit'])->name('rules.edit')->middleware('check_page_permission:/rules,edit_permission,0');//->middleware('can:read master');
   /****************************/
    Route::get('/conditions/create', [ConditionsController::class, 'create'])->name('conditions.create')->middleware('check_page_permission:/rules,add_permission,0');//->middleware('can:read master');
    Route::get('/conditions/edit', [ConditionsController::class, 'edit'])->name('conditions.edit')->middleware('check_page_permission:/rules,edit_permission,0');//->middleware('can:read master');
    Route::post('/conditions/store', [ConditionsController::class, 'store'])->name('conditions.store')->middleware('check_page_permission:/rules,add_permission,0');//->middleware('can:read master');
    Route::post('/conditions/update', [ConditionsController::class, 'update'])->name('conditions.update')->middleware('check_page_permission:/rules,edit_permission,0');//->middleware('can:read master');
    Route::post('/conditions/destroy', [ConditionsController::class, 'destroy'])->name('conditions.destroy')->middleware('check_page_permission:/rules,delete_permission,0');//->middleware('can:read master');
    //Employee
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee')->middleware('check_page_permission:/employee,view_permission,0');//->middleware('can:read employee');
    Route::get('/addemployee', [EmployeeController::class, 'create'])->name('addemployee')->middleware('check_page_permission:/employee,add_permission,0');//->middleware('can:create employee');
    Route::post('/employee/createemployee', [EmployeeController::class, 'store'])->name('createemployee')->middleware('check_page_permission:/employee,add_permission,0');//->middleware('can:create employee');
    Route::post('/updateemployee', [EmployeeController::class, 'update'])->name('updateemployee')->middleware('check_page_permission:/employee,edit_permission,0');//->middleware('can:update employee'); //NOT YET CHECKED AS IT IS NOT WORKING
    Route::get('/employee/{id}', [EmployeeController::class, 'edit'])->name('employee/{id}')->middleware('check_page_permission:/employee,edit_permission,0');//->middleware('can:update employee'); //NOT YET CHECKED AS IT IS NOT WORKING
    Route::POST('/employee/edit', [EmployeeController::class, 'edit'])->name('employee')->middleware('check_page_permission:/employee,edit_permission,0');//->middleware('can:read employee');
    Route::post('/employee/updateemployee/{id}', [EmployeeController::class, 'updateEmployee'])->name('updateemployee')->middleware('check_page_permission:/employee,edit_permission,0');//->middleware('can:update employee'); //NOT YET CHECKED AS IT IS NOT WORKING
    Route::post('/employee/toggleemployeestatus/{id}', [EmployeeController::class, 'toggleemployeestatus'])->name('toggleemployeestatus')->middleware('check_page_permission:/employee,edit_permission,0');//->middleware('can:update employee'); //NOT YET CHECKED AS IT IS NOT WORKING
   //Leaves
    Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves')->middleware('check_page_permission:/leaves,view_permission,0');
    Route::post('/leaves/storeleaves', [LeaveController::class, 'storeleaves'])->name('storeleaves')->middleware('check_page_permission:/leaves,add_permission,0');
    Route::get('/leaves/{id}', [LeaveController::class, 'leavelist'])->name('leaves')->middleware('check_page_permission:/leaves,view_permission,0');
    Route::get('/leaves/calendar/{id}', [LeaveController::class, 'leavecalendar'])->name('leaves')->middleware('check_page_permission:/leaves,view_permission,0');
    Route::get('/leaves/getById/{id}', [LeaveController::class, 'getLeaveData'])->name('getLeaveData')->middleware('check_page_permission:/leaves,view_permission,0');
    Route::post('/leaves/updateleave/{id}', [LeaveController::class, 'updateleave'])->name('updateleave')->middleware('check_page_permission:/leaves,edit_permission,0');
    Route::post('/leaves/destroy', [LeaveController::class, 'destroy'])->name('leaves')->middleware('check_page_permission:/leaves,delete_permission,1');
    //Roles
    Route::get('/role', [RoleController::class, 'index'])->name('role')->middleware('check_page_permission:/role,view_permission,0');
    Route::post('/role/destroy', [RoleController::class, 'destroy'])->name('destroy')->middleware('check_page_permission:/role,delete_permission,1');
    Route::get('/role/{id}', [RoleController::class, 'edit'])->name('role/{id}')->middleware('check_page_permission:/role,edit_permission,0');
    Route::post('/createrole', [RoleController::class, 'store'])->name('createrole')->middleware('check_page_permission:/role,add_permission,0');
    Route::post('/updaterole', [RoleController::class, 'update'])->name('updaterole')->middleware('check_page_permission:/role,edit_permission,0');
    //Menu Permission Role Wise
    Route::get('/permissions/role-list', [MenusPermissionController::class, 'rolelist'])->name('rolelist')->middleware('check_page_permission:/permissions/role-list,view_permission,0');//->middleware('can:read master');
    Route::get('/role-permission/menu-list/{roleId}', [MenusPermissionController::class, 'managerolepermission'])->name('managerolepermission')->middleware('check_page_permission:/permissions/role-list,view_permission,0');//->middleware('can:read master');
    Route::post('/menus/role/set-single-permissions/{roleId}', [MenusPermissionController::class, 'setSinglePermissionByRole'])->name('menuspermission/{id}')->middleware('check_page_permission:/permissions/role-list,edit_permission,0');//->middleware('can:update master');
    //Leads
    Route::get('/leads', [LeadController::class, 'index'])->name('leads.index')->middleware('check_page_permission:/leads,view_permission,0');//->middleware('can:read master');
    Route::get('/leads/show/{id}', [LeadController::class, 'show'])->name('leads.show')->middleware('check_page_permission:/leads,view_permission,0');//->middleware('can:read master');
    Route::post('/leads/store', [LeadController::class, 'store'])->name('leads.store')->middleware('check_page_permission:/leads,add_permission,0');//->middleware('can:read master');
    Route::get('/leads/create', [LeadController::class, 'create'])->name('leads.create')->middleware('check_page_permission:/leads,add_permission,0');//->middleware('can:read master');
    Route::get('/leads/edit/{id}', [LeadController::class, 'edit'])->name('leads.edit')->middleware('check_page_permission:/leads,edit_permission,0');//->middleware('can:read master');
    Route::post('/leads/updatelead/{id}', [LeadController::class, 'updatelead'])->name('leads.updatelead')->middleware('check_page_permission:/leads,edit_permission,0');//->middleware('can:read master');
    Route::get('/leads/calls', [LeadController::class, 'call'])->name('leads.call')->middleware('check_page_permission:/leads/calls,view_permission,0');//->middleware('can:read master');
    Route::get('/leads/calls/{id}', [LeadController::class, 'showcall'])->name('leads.showcall')->middleware('check_page_permission:/leads,view_permission,0');//->middleware('can:read master');
    Route::post('/leads/calls/{id}', [LeadController::class, 'update'])->name('leads.update')->middleware('check_page_permission:/leads,edit_permission,0');
    Route::get('/leads/followup', [LeadController::class, 'followup'])->middleware('check_page_permission:/leads/followup,view_permission,0');;//->middleware('can:read master');
    Route::get('/leads/calls/edit/{id}', [LeadController::class, 'showcalledit'])->name('leads.showcalledit')->middleware('check_page_permission:/leads,edit_permission,0');//->middleware('can:read master');;//->middleware('can:read master');
    Route::post('/leads/calls/{id}/email', [LeadController::class, 'email'])->name('leads.email')->middleware('check_page_permission:/leads,edit_permission,0');
    Route::post('/leads/calls/{id}/whatsapp', [LeadController::class, 'whatsapp'])->name('leads.whatsapp')->middleware('check_page_permission:/leads,edit_permission,0');
    Route::post('/leads/calls/{id}/call', [LeadController::class, 'leadcall'])->name('leads.leadcall')->middleware('check_page_permission:/leads,edit_permission,0');//->middleware('can:read master');
    Route::post('/leads/upload', [LeadController::class, 'upload'])->name('leads.upload')->middleware('check_page_permission:/leads,add_permission,0');//->middleware('can:read master');
    Route::get('/leads/export', [LeadController::class, 'export'])->name('leads.export')->middleware('check_page_permission:/leads,view_permission,0');//->middleware('can:read master');

    //Logs
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index')->middleware('check_page_permission:/logs,view_permission,0');;//->middleware('can:read master');
    //Communications
    Route::get('/communications', [CommunicationController::class, 'index'])->name('communications.index')->middleware('check_page_permission:/communications,view_permission,0');//->middleware('can:read master');
    Route::post('/communications/store', [CommunicationController::class, 'store'])->name('communications.store')->middleware('check_page_permission:/communications,add_permission,0');//->middleware('can:read master');
    Route::post('/communications/update', [CommunicationController::class, 'update'])->name('communications.update')->middleware('check_page_permission:/communications,edit_permission,0');//->middleware('can:read master');//->middleware('can:read master');
    Route::post('/communications/destroy', [CommunicationController::class, 'destroy'])->name('communications.destroy')->middleware('check_page_permission:/communications,delete_permission,0');//->middleware('can:read master');//->middleware('can:read master');
    Route::get('/communications/{id}/leads', [CommunicationController::class, 'leads'])->name('/communications/{id}/leads')->middleware('check_page_permission:/communications,view_permission,0');//->middleware('can:read master');
    //Designation
    Route::get('/designation', [DesignationController::class, 'index'])->name('designation')->middleware('check_page_permission:/designation,view_permission,0');
    Route::post('/designation', [DesignationController::class, 'store'])->name('designation')->middleware('check_page_permission:/designation,add_permission,0');
    Route::get('/designation/{id}', [DesignationController::class, 'edit'])->name('designation/{id}')->middleware('check_page_permission:/designation,edit_permission,0');
    Route::post('/designation/{id}', [DesignationController::class, 'update'])->name('designation/{id}')->middleware('check_page_permission:/designation,edit_permission,0');
    Route::post('/designation/delete/{id}', [DesignationController::class, 'destroy'])->name('/designation/delete/{id}')->middleware('check_page_permission:/designation,delete_permission,0');
    Route::get('/users', [UserController::class, 'index'])->name('listusers')->middleware('check_page_permission:/users,view_permission,0');
    Route::get('/users/profile', [UserController::class, 'profile'])->name('viewprofile');//->middleware('check_page_permission:/users,view_permission,0');
    Route::post('/users/updateprofile', [UserController::class, 'updateprofile'])->name('updateprofile');//->middleware('check_page_permission:/users,view_permission,0');
    Route::get('/users/change-password', [UserController::class, 'userpassword'])->name('userpassword');//->middleware('check_page_permission:/users,view_permission,0');
    Route::post('/users/updatepassword', [UserController::class, 'updatepassword'])->name('updatepassword');//->middleware('check_page_permission:/users,view_permission,0');
    //In Progress
    
   
    Route::post('/leads/update', [LeadController::class, 'updateone'])->name('leads.updateone')->middleware('check_page_permission:/leads,edit_permission,0');//->middleware('can:read master');
    //Communications
    //->middleware('can:read master');
    // Route::get('/leadassignment', [LeadController::class, 'assignment'])->name('leads');//->middleware('can:read lead');
    // Route::get('/leads/{id}', [LeadController::class, 'showtoedit'])->name('leads.showtoedit');//->middleware('can:read master');

    //Logs
    //NYD Block#2 Content
    //Permissions 

    //Useless ROutes Start
    Route::get('/employees/permissions', [PermissionsController::class, 'index'])->name('permissions.index');//->middleware('can:read employee'); //NOT DONE YET Because  I don't think it is relavent now
    Route::get('/employees/permissions/{id}', [PermissionsController::class, 'edit'])->name('permissions.edit');//->middleware('can:read employee'); //NOT DONE YET Because  I don't think it is relavent now
    Route::post('/employees/permissions/{id}', [PermissionsController::class, 'update'])->name('permissions.update');//->middleware('can:read employee'); //NOT DONE YET Because  I don't think it is relavent now
    Route::get('/employees/permissions/{id}/masters', [PermissionsController::class, 'masterindex'])->name('permissions.masterindex');//-->middleware('can:read employee'); //NOT DONE YET Because  I don't think it is relavent now
    Route::get('/permissions/employee-list', [MenusPermissionController::class, 'index'])->name('menuspermission')->middleware('can:read master');
    Route::get('/permissions/menu-list/{employeeId}', [MenusPermissionController::class, 'managePermission'])->name('menuspermission')->middleware('can:read master');
    Route::post('/menus/set-all-permissions/{employeeId}', [MenusPermissionController::class, 'setPermission'])->name('menuspermission/{id}')->middleware('can:update master');
    Route::post('/menus/set-single-permissions/{employeeId}', [MenusPermissionController::class, 'setSinglePermission'])->name('menuspermission/{id}')->middleware('can:update master');
    Route::post('/menuspermission/{id}', [MenusPermissionController::class, 'update'])->name('menuspermission/{id}')->middleware('can:update master');
    Route::delete('menuspermission/{id}', [MenusPermissionController::class, 'delete'])->name('menuspermission.delete');

    //Useless ROutes End
    
    // Route::post('/addDoctors', [DoctorController::class, 'addDoctors'])->name('addDoctors')->middleware('can:read master');
    Route::get('/master/main/edit/{id}', [MainMasterController::class, 'remove'])->name('/master/main/edit/{id}')->middleware('check_page_permission:/master,edit_permission,0, 1');//->middleware('can:delete master');
    Route::delete('/master/main/remove/{id}', [MainMasterController::class, 'delete'])->name('mainmaster.delete')->middleware('check_page_permission:/master,delete_permission,0, 1');
    
    //Permission
    // Route::get('/permission', [PermissionController::class, 'index'])->name('permission');//->middleware('can:read role');
    // Route::get('/permission/{id}', [PermissionController::class, 'edit'])->name('permission/{id}');//->middleware('can:update role');
    // Dynamic Master
    Route::post('/dynamic/destroy-dynamic-value', [DynamicMasterController::class, 'destroyDynamicValue'])->name('destroyDynamicValue')->middleware('can:read master');
    Route::get('/dynamic/edit/{id}', [DynamicMasterController::class, 'edit'])->name('/dynamic/edit/{id}')->middleware('can:update master');
    Route::post('/dynamic/edit/{id}', [DynamicMasterController::class, 'update'])->name('/dynamic/edit/{id}')->middleware('can:update master');

    //Not To be Used
    Route::get('/locations', [LocationController::class, 'index'])->name('cities');//->middleware('can:read lead');
    Route::get('/assign', [RoleController::class, 'assign'])->name('assign');//->middleware('can:assign role'); //NOT DONE YET
    Route::get('/assign-role', function () { return view('assignrole'); });//NOT DONE YET
    Route::get('/createmaste', [RoleController::class, 'assign'])->name('assign');//->middleware('can:assign role'); //NOT DONE YET Because  Page Not Working
    Route::get('/master/{id}', [RoleController::class, 'assign'])->name('assign');//->middleware('can:assign role'); //NOT DONE YET Because This Rout Is Duplicate of Rout on  Line No 117
    Route::get('/actiontype', [RoleController::class, 'assign'])->name('assign');//->middleware('can:assign role');//NOT DONE YET Because  Page Not Working
    Route::get('/leadtype', [RoleController::class, 'assign'])->name('assign');//->middleware('can:assign role');//NOT DONE YET Because  Page Not Working
    Route::get('/state', [RoleController::class, 'assign'])->name('assign');//->middleware('can:assign role');//NOT DONE YET Because  Page Not Working
    Route::get('/city', [RoleController::class, 'assign'])->name('assign');//->middleware('can:assign role'); //NOT DONE YET Because  Page Not Working
    //Other Management
    Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');//->middleware('can:read master');
    Route::get('/quotes', [QuoteController::class, 'index'])->name('quotes.index');//->middleware('can:read master');
    Route::get('/occasions', [OccasionController::class, 'index'])->name('occasions.index');//->middleware('can:read master'); 
    //State
    Route::get('/states', [StateController::class, 'index'])->name('states');//->middleware('can:read lead');
    //City
    Route::get('/cities', [CityController::class, 'index'])->name('cities');//->middleware('can:read lead');
    //Action Type
    Route::get('/actions', [ActionTypeController::class, 'index'])->name('actions');//->middleware('can:read lead');
    // Template Master


});


