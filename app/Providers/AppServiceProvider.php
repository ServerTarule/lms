<?php

namespace App\Providers;

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
           
            $user = Auth::user();
            $userId = $user?$user->id:0;
            // echo "User Id is ".$userId;
            

            $currentRoutname = (Route::getCurrentRoute())?Route::getCurrentRoute()->getName():'';
            // $currentRoutname = ($this->app->request->getRequestUri())?$this->app->request->getRequestUri():'';
            // echo "currentRoutname".$currentRoutname;
            $userCrudPermissions = [
                'add_permission'=> false,
                'edit_permission'=> false,
                'view_permission'=> false,
                'delete_permission'=> false,
            ];
            $userCrudPermissionsDb =[];
            if($currentRoutname) {
                $menuUrl =  '/'.$currentRoutname;
                // $menuUrl =  $currentRoutname;//
                $menuUrlArr = explode('/',$menuUrl);
                // echo "<pre>";print_r($menuUrlArr);
                $menuUrlToCompare = (count($menuUrlArr) > 2) ? "/".$menuUrlArr[1]:$menuUrl;
                $query = "SELECT m.title, m.url,mp.id as mId,mp.menu_id, mp.employee_id,mp.add_permission,mp.edit_permission,mp.view_permission,mp.delete_permission from menus m INNER JOIN menu_permissions mp  on m.id = mp.menu_id 
                where mp.employee_id = $userId and  m.url = '$menuUrl'";
                // echo "Query = ".$query;
                $menuPermissions = DB::select($query);
                $userCrudPermissionsDb = (isset($menuPermissions) && isset($menuPermissions[0])) ?  json_decode(json_encode($menuPermissions[0]), true):[];//['add_permission'=>0,'edit_permission'=0,'delete_permission'=>0,'view_permission'=>0];
            }
            // echo "<pre>";print_r($userCrudPermissionsDb);
            if(isset($userCrudPermissionsDb) && !empty($userCrudPermissionsDb)) {
                $userCrudPermissions['add_permission'] = ($userCrudPermissionsDb["add_permission"] == '1') ? true:false;
                $userCrudPermissions['edit_permission'] = ($userCrudPermissionsDb["edit_permission"] == '1') ? true:false;
                $userCrudPermissions['view_permission'] = ($userCrudPermissionsDb["view_permission"] == 1) ? true:false;
                $userCrudPermissions['delete_permission'] = ($userCrudPermissionsDb["delete_permission"] == 1) ? true:false;
            }
            // print_r($userCrudPermissions);die;
            $view->with('userCrudPermissions', $userCrudPermissions );    
        });  


    }
}
