<?php

namespace App\Providers;

use App\Http\Middleware\PreMappedAuthorizationRoutes;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Route;
use App\Models\Employee;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        // echo "Provider register--";
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->share('rule', null);
        view()->share('masters', []);
        view()->share('leadMasters', []);
        view()->share('masterValues',[]);
        //compose all the views....
        view()->composer('*', function ($view) 
        {
            
            $routeObj = new PreMappedAuthorizationRoutes();

            $authRoutesArray = $routeObj->dynamicMasterAuthorizationRoutes;
            $dynaicRouteActions = $routeObj->dynaicRouteActions;
            $dynaicLeaveActions = $routeObj->dynaicLeaveActions;
            $dynaicRolePermissionActions = $routeObj->dynaicRolePermissionActions;
            $dynaicLeadsPermissionActions= $routeObj->dynaicLeadsPermissionActions;
            $dynaicLeadsCommunicationLeadsActions= $routeObj->dynaicLeadsCommunicationLeadsActions;
            $actionFullPath = Route::currentRouteAction();
            $actionArray = explode('@',$actionFullPath);
            $actionName = (!empty($actionArray) && isset($actionArray[1]))? $actionArray[1]:"not-a-recognised-action";
            // echo " </br>actionName ----".$actionName;
            $user = Auth::user();
            $userId = $user?$user->id:0;
            $currentEmployeeDetails = [];
            if($userId){
                $employee=Employee::where('user_id',$userId)->get();
                if(count($employee) > 0) {
                    $currentEmployeeDetails=$employee[0];
                }
            }
            $roleId = $user?$user->role_id:0;
            if($roleId === 6) {
                $userCrudPermissions = [
                    'add_permission'=> true,
                    'edit_permission'=> true,
                    'view_permission'=> true,
                    'delete_permission'=> true,
                ];
            }
            else {
                // $currentRoutname = (Route::getCurrentRoute())?Route::getCurrentRoute()->getName():'';
                $currentRoutname = ($this->app->request->getRequestUri())?$this->app->request->getRequestUri():'';
                // echo "currentRoutname".$currentRoutname;
                $lastCharecter = $currentRoutname[strlen($currentRoutname)-1];
                if($lastCharecter == "/" || $lastCharecter == "#") {
                    $currentRoutname = substr($currentRoutname, 0, -1);
                }

                // echo "\n New currentRoutname is \n :  ".$currentRoutname;
                // $bypassProvider = 1;
                $userCrudPermissions = [
                    'add_permission'=> false,
                    'edit_permission'=> false,
                    'view_permission'=> false,
                    'delete_permission'=> false,
                ];
                $userCrudPermissionsDb =[];
                if($currentRoutname) {
                    $slashPosition =  strpos($currentRoutname,"/");
                    // echo "slashPosition ===".$slashPosition;
                    // echo "----->".$currentRoutname."<------";
                    if($slashPosition == 0) {
                        $menuUrl =  $currentRoutname;
                    }
                    else {
                        $menuUrl =  '/'.$currentRoutname;
                    }

                    
                    // echo "\n -----".$menuUrl;
                    // $menuUrl =  $currentRoutname;//
                    $menuUrlArr = explode('/',$menuUrl);
                    if(isset($authRoutesArray[$actionName]) && in_array($actionName,$dynaicRouteActions)) {
                        // echo "---construct pre defined menu url for dynamic routes--";
                        $idIndex = $authRoutesArray[$actionName]["idIndexInUri"];
                        $dynamicMasterPathArray = explode('/',$this->app->request->getRequestUri());
                        $dynamicMasterId = isset($dynamicMasterPathArray[$idIndex])?$dynamicMasterPathArray[$idIndex]:"";
                        $menuUrl = '/master/main/'.$dynamicMasterId;
                        // echo " </br>currentPath ----".$currentPath;
                    }
                    else if(isset($authRoutesArray[$actionName]) && in_array($actionName,$dynaicLeaveActions)) {
                        $menuUrl = '/leaves';
                    }
                    else if(isset($authRoutesArray[$actionName]) && in_array($actionName,$dynaicRolePermissionActions)) {
                        $menuUrl = '/permissions/role-list';
                    }
                    else if(isset($authRoutesArray[$actionName]) && in_array($actionName,$dynaicLeadsPermissionActions)) {
                        $menuUrl = '/leads';
                    }
                    else if(isset($authRoutesArray[$actionName]) && in_array($actionName,$dynaicLeadsCommunicationLeadsActions)) {
                        $menuUrl = '/communications';
                    }
                    //leads
                    // echo "<br> Menu Url =".$menuUrl;

                    // echo "<pre>";print_r($menuUrlArr);
                    $menuUrlToCompare = (count($menuUrlArr) > 2) ? "/".$menuUrlArr[1]:$menuUrl;
                    // $query = "SELECT m.title, m.url,mp.id as mId,mp.menu_id, mp.employee_id,mp.add_permission,mp.edit_permission,mp.view_permission,mp.delete_permission from menus m INNER JOIN menu_permissions mp  on m.id = mp.menu_id 
                    // where mp.employee_id = $userId and  m.url = '$menuUrl'";
                    $query = "SELECT m.title, m.url,mp.id as mId,mp.menu_id, mp.role_id,mp.add_permission,mp.edit_permission,mp.view_permission,mp.delete_permission from menus m INNER JOIN menu_role_permissions mp  on m.id = mp.menu_id 
                    where mp.role_id = $roleId and  m.url = '$menuUrl' and m.deleted != 1";

                    // echo "Query = ".$query;
                    $menuPermissions = DB::select($query);
                    // print_r($menuPermissions );
                    $userCrudPermissionsDb = (isset($menuPermissions) && isset($menuPermissions[0])) ?  json_decode(json_encode($menuPermissions[0]), true):[];//['add_permission'=>0,'edit_permission'=0,'delete_permission'=>0,'view_permission'=>0];
                }
                if(isset($userCrudPermissionsDb) && !empty($userCrudPermissionsDb)) {
                    $userCrudPermissions['add_permission'] = ($userCrudPermissionsDb["add_permission"] == '1') ? true:false;
                    $userCrudPermissions['edit_permission'] = ($userCrudPermissionsDb["edit_permission"] == '1') ? true:false;
                    $userCrudPermissions['view_permission'] = ($userCrudPermissionsDb["view_permission"] == 1) ? true:false;
                    $userCrudPermissions['delete_permission'] = ($userCrudPermissionsDb["delete_permission"] == 1) ? true:false;
                }
            }
            // print_r($user);die;
            // echo "==currentEmployeeDetails===".$currentEmployeeDetails;
            // print_r($userCrudPermissions);
            $view->with(['userCrudPermissions'=> $userCrudPermissions,'currentuser'=>$user,'currentEmployeeDetails'=>$currentEmployeeDetails] );    
        });  
    }
}
