<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Exceptions\UnauthorizedException;
use App\Http\Middleware\PreMappedAuthorizationRoutes;

class CheckPagePermission
{
    /**`
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $menuUrl, $permisionToCheck,$returnJsonRespone=0, $useCurrentUrl=0, $guard=null)
    {

        $routeObj = new PreMappedAuthorizationRoutes();
        $authRoutesArray = $routeObj->dynamicMasterAuthorizationRoutes;
        //    echo "</br> menuUrl = ". $menuUrl;
        //    echo "</br> useCurrentUrl = ".$useCurrentUrl;
        //    echo "<pre>";print_r($authRoutesArray);
        $user = Auth::user();
        if(isset($user)) {
            $userArray= $user->toArray();
            if($userArray['role_id']) {
                $roleId = $userArray['role_id'];
                // print_r($userArray);die;
                $userId = $user->id;
                $url = $request->url();
                $currentPath = trim($menuUrl);
                if($roleId === 6){
                    return $next($request);
                }
                // echo "--useCurrentUrl--".$useCurrentUrl;
                
                if($useCurrentUrl == 1) {
                    $currentPath = ($request->getRequestUri())?$request->getRequestUri():'';
                }
                // useCurrentUrl is 2 for CRUD of dynamic masters
                else if($useCurrentUrl == 2) { 
                    // echo " </br>condition 2----";
                   
                    // print_r($dynamicMasterPathArray);
                    $actionFullPath = Route::currentRouteAction();
                    $actionArray = explode('@',$actionFullPath);
                    $actionName = (!empty($actionArray) && isset($actionArray[1]))? $actionArray[1]:"not-a-recognised-action";
                    // echo " </br>actionName ----".$actionName;
                    // echo $actionNameIndex = $dynamicMasterId?($actionName."_".$dynamicMasterId):$actionName;
                    // echo $currentPath = $authRoutesArray[$actionName];
                    // echo "<pre>";print_r($authRoutesArray[$actionName]);
                    if($authRoutesArray[$actionName]["process"] === true) {
                        $idIndex = $authRoutesArray[$actionName]["idIndexInUri"];
                        $dynamicMasterPathArray = explode('/',$request->getRequestUri());
                        $dynamicMasterId = isset($dynamicMasterPathArray[$idIndex])?$dynamicMasterPathArray[$idIndex]:"";
                        $currentPath = '/master/main/'.$dynamicMasterId;
                        // echo " </br>currentPath ----".$currentPath;
                    }
                }
                else if($useCurrentUrl == 3 && isset($authRoutesArray[$currentPath])) {
                    $currentPath = $authRoutesArray[$currentPath];
                }
                
                
                // echo "</br>  currentPath issssssssssss: </br>  ".$currentPath;die;
                $query = "SELECT m.title, m.url,mp.id as mId,mp.menu_id, mp.role_id,mp.add_permission,mp.edit_permission,mp.view_permission,mp.delete_permission from menus m INNER JOIN menu_role_permissions mp  on m.id = mp.menu_id 
                where mp.role_id = $roleId and m.url = '$currentPath'";
                $menuPermissions = DB::select($query);
                $menuPermissionsArray =  (isset($menuPermissions) && isset($menuPermissions[0]))?json_decode(json_encode($menuPermissions[0]),true):[];
                // print_r($menuPermissionsArray );die;
                if(!isset($menuPermissionsArray) || empty($menuPermissionsArray) || !isset($menuPermissionsArray[$permisionToCheck]) || $menuPermissionsArray[$permisionToCheck]==0 ) {
                    if($returnJsonRespone == 0) {
                        abort(403, "You are not allowed to perform this action!");
                    }
                    else {
                        return response('You are not allowed to perform this action!',403);
                    }
                }
                return $next($request);
            }
            else {
                abort(403, "You are not allowed to perform this action!");
            }
        }
        else {
            abort(403, "You are not allowed to perform this action!");
        }
    }
}