<?php

namespace App\Providers;

use App\Http\Middleware\PreMappedAuthorizationRoutes;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Route;
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
            $actionFullPath = Route::currentRouteAction();
            $actionArray = explode('@',$actionFullPath);
            $actionName = (!empty($actionArray) && isset($actionArray[1]))? $actionArray[1]:"not-a-recognised-action";
            // echo " </br>actionName ----".$actionName;
            $user = Auth::user();
            $userId = $user?$user->id:0;
            $roleId = $user?$user->role_id:0;
            // echo "User Id is ".$userId."===roleId===".$roleId;

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
                    // echo "<pre>";print_r($menuUrlArr);
                    $menuUrlToCompare = (count($menuUrlArr) > 2) ? "/".$menuUrlArr[1]:$menuUrl;
                    // $query = "SELECT m.title, m.url,mp.id as mId,mp.menu_id, mp.employee_id,mp.add_permission,mp.edit_permission,mp.view_permission,mp.delete_permission from menus m INNER JOIN menu_permissions mp  on m.id = mp.menu_id 
                    // where mp.employee_id = $userId and  m.url = '$menuUrl'";
                    $query = "SELECT m.title, m.url,mp.id as mId,mp.menu_id, mp.role_id,mp.add_permission,mp.edit_permission,mp.view_permission,mp.delete_permission from menus m INNER JOIN menu_role_permissions mp  on m.id = mp.menu_id 
                    where mp.role_id = $roleId and  m.url = '$menuUrl'";

                    // echo "Query = ".$query;
                    $menuPermissions = DB::select($query);
                    $userCrudPermissionsDb = (isset($menuPermissions) && isset($menuPermissions[0])) ?  json_decode(json_encode($menuPermissions[0]), true):[];//['add_permission'=>0,'edit_permission'=0,'delete_permission'=>0,'view_permission'=>0];
                }
                if(isset($userCrudPermissionsDb) && !empty($userCrudPermissionsDb)) {
                    $userCrudPermissions['add_permission'] = ($userCrudPermissionsDb["add_permission"] == '1') ? true:false;
                    $userCrudPermissions['edit_permission'] = ($userCrudPermissionsDb["edit_permission"] == '1') ? true:false;
                    $userCrudPermissions['view_permission'] = ($userCrudPermissionsDb["view_permission"] == 1) ? true:false;
                    $userCrudPermissions['delete_permission'] = ($userCrudPermissionsDb["delete_permission"] == 1) ? true:false;
                }
            }
            // echo "<pre>";
            // print_r($userCrudPermissions);
            $view->with('userCrudPermissions', $userCrudPermissions );    
        });  
    }
}
