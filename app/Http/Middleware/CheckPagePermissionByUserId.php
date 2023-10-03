<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CheckPagePermissionByUserId
{
    /**
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
    public function handle($request, Closure $next, $menuUrl, $permisionToCheck,$returnJsonRespone=0, $useCurrentUrl=1, $guard=null)
    {
       
        $user = Auth::user();
        $userId = $user->id;
        $url = $request->url();
        $currentPath = trim($menuUrl);
        if($useCurrentUrl){
            
        }
        // echo $currentPath;
        // abort(403, "Can't perform this action!");
        $query = "SELECT m.title, m.url,mp.id as mId,mp.menu_id, mp.employee_id,mp.add_permission,mp.edit_permission,mp.view_permission,mp.delete_permission from menus m INNER JOIN menu_permissions mp  on m.id = mp.menu_id 
        where mp.employee_id = $userId and m.url = '$currentPath'";
        $menuPermissions = DB::select($query);
        $menuPermissionsArray =  (isset($menuPermissions) && isset($menuPermissions[0]))?json_decode(json_encode($menuPermissions[0]),true):[];
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
}