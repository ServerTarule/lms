<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Menu;
use App\Models\MenuPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenusPermissionController extends Controller
{
    public function index(){
        $employees = Employee::all();
        return view('menus-permissions.index',compact("employees"));
    }

    public function managePermission($employeeId){
        $menuPermissions = DB::table('menus as m')->leftJoin('menu_permissions as mp', 'm.id', '=', 'mp.menu_id')->leftJoin('menus as parM', 'm.parent_id', '=', 'parM.id')
            ->select('m.*','parM.title as parentname', 'mp.id as mId', 'mp.menu_id', 'mp.employee_id', 'mp.add_permission', 'mp.edit_permission', 'mp.view_permission', 'mp.delete_permission', 'mp.created_at as mp_created_at')
            ->orderBy('preference','asc')->get();
        return view('menus-permissions.edit',compact("menuPermissions","employeeId"));
    }

    

    private function upsertPermissions($employeeId, $permissionData) {

        // echo "--employeeId--".$employeeId; print_r($permissionData);
        MenuPermission::unguard();
        MenuPermission::updateOrCreate(
            [
                'employee_id' => $employeeId, 'menu_id' => $permissionData['menu_id']
            ],
            [
                'add_permission' => $permissionData['add_permissions'],
                'edit_permission' => $permissionData['edit_permissions'],
                'delete_permission' => $permissionData['delete_permissions'],
                'view_permission' => $permissionData['view_permissions'],
            
            ]);
        MenuPermission::reguard();
    }

    public function getMenuHierarchy($menuId) {
        $menu = Menu::find($menuId);
        return $menu->getDescendants($menu);
    }

    public function getChildMenu($menuId, $removeCurrentId = false) {
        $menu = Menu::find($menuId);
        $menu = $menu->getDescendants($menu);
        // $menu = DB::table('menus as m')->where('parent_id',$menuId)->select('m.id')->get()->toArray();
        // $menu = Menu::where('parent_id', $menuId)->pluck('id')->toArray();
        // echo "-------child menu------>"; print_r($menu);echo "<------------"; 
        if($removeCurrentId) {
            if (($key = array_search($menuId, $menu)) !== false) {
                unset($menu[$key]);
            }
        }
        return $menu;
    }


    public function setSinglePermission(Request $request){
        $employeeId = $request->get('employeeId');
        $permissionData = $request->get('permissionData');
        $permissionData = json_decode( $permissionData, true );
        try {
            $this->processSinglePermission($permissionData, $employeeId );
        }
        catch (Request $e) {
            throw new \Exception($e->getMessage());
        }
        return response()->json(['message'=>'Employee menu permissions data updated successfuly.' ]);
    }

    private function processSinglePermission($permissionData, $employeeId) {
        $menuId = $permissionData["menu_id"];
        $menu_ids = $this->getMenuHierarchy($menuId);
        $parentId = $permissionData['parent_id'];

        foreach($menu_ids as $menu_id) {


            if($parentId > 0) {

                // echo "Parent id is non ero".$parentId;
                $parentPermissions = MenuPermission::where('menu_id',$parentId)->select('add_permission','edit_permission','delete_permission','view_permission')->first()->toArray();
            
                $isValidAddPerm = ($parentPermissions['add_permission'] == $permissionData['add_permissions']);
                
                $isValidEditPerm = ($parentPermissions['edit_permission'] == $permissionData['edit_permissions']);
                
                $isValidDeletePerm = ($parentPermissions['delete_permission'] == $permissionData['delete_permissions']);
    
                $isValidViewPerm = ($parentPermissions['view_permission'] == $permissionData['view_permissions']);
    
    
                // echo "For Menu Id ".$menu_id."==start==="."\n";
                // echo "isValidAddPerm=".$isValidAddPerm;
                // echo "\n";
                // echo "isValidEditPerm=".$isValidEditPerm;
                // echo "\n";
                // echo "isValidDeletePerm=".$isValidDeletePerm;
                // echo "\n";
                // echo "isValidDeletePerm=".$isValidDeletePerm;
                // echo "\n";
                // echo "For Menu Id ".$menu_id."==end==="."\n";
    
    
                if(!$isValidAddPerm || !$isValidEditPerm || !$isValidDeletePerm || !$isValidViewPerm) {
                    
                   //abort(403, 'Unauthorized action.');
    
                    //return response()->view('errors.403', array('message' => 'Sellist kasutajatüüpi ei eksisteeri!'), 403);
    
                     throw new \Error('Please make sure parent menu permissions are same as child menu permissions.');
                    //return response()->json(null, 403);;//response()->json('Unauthorized.', 401);
                    //return response()->json(['Error' => 'Please make sure parent menu permissions are same as child menu permissions.']);
                }
    
            }
           

            MenuPermission::unguard();
            MenuPermission::updateOrCreate(
                [
                    'employee_id' => $employeeId, 'menu_id' => $menu_id
                ],
                [
                    'add_permission' => $permissionData['add_permissions'],
                    'edit_permission' => $permissionData['edit_permissions'],
                    'delete_permission' => $permissionData['delete_permissions'],
                    'view_permission' => $permissionData['view_permissions'],
                
                ]);
            MenuPermission::reguard();
        }
        return response()->json(['success' => 'Received employee menu permissions data']);
    }



    public function setPermission(Request $request){
        $employeeId = $request->get('employeeId');
        $permissionsData = $request->get('permissionsData');
        $permissionsData = json_decode( $permissionsData, true );
        try {
            $idsToSkip = [];
            $idWisePermissions = [];
            foreach($permissionsData as $permissionData) {
                $currentMenuId =$permissionData['menu_id'];
                $parentId = $permissionData["parent_id"];
                
                $oldPermissions = MenuPermission::where('menu_id',$currentMenuId)->select('add_permission','edit_permission','delete_permission','view_permission')->first()->toArray();
                 
                $oldPermissionsStr = implode("#",$oldPermissions);
                $newPermissionsStr = $permissionData['add_permissions'].'#'.$permissionData['edit_permissions'].'#'.$permissionData['delete_permissions'].'#'.$permissionData['view_permissions'];

                    echo "Processing for ".$currentMenuId;
                    echo "Inside if 1    children \n";
                    $this->upsertPermissions($employeeId,$permissionData);
                //}
                $children = $this->getChildMenu($currentMenuId,true);
               // print_r($children);
                if(count($children) > 0 && $parentId == 0) {
                    foreach($children as $child) {
                        $chilePermissionData = [
                            "menu_id"=> $child,
                            "add_permissions"=> $permissionData['add_permissions'],
                            "edit_permissions"=> $permissionData['edit_permissions'],
                            "delete_permissions"=> $permissionData['delete_permissions'],
                            "view_permissions"=> $permissionData['view_permissions'],
                        ];
                        echo "Processing for ".$child;
                        echo "Inside Loop 1 \n";
                        $this->upsertPermissions($employeeId,$chilePermissionData );
                        $idsToSkip[] = $child;
                    }
                }
                else if(count($children) > 0 && $parentId !== 0 ||  $oldPermissionsStr !== $newPermissionsStr) {
                    // foreach($children as $child) {
                    //     $parentPermissions = MenuPermission::where('menu_id',$parentId)->first()->toArray();
                    //     $chilePermissionData = [
                    //         "menu_id"=> $child,
                    //         "add_permissions"=> $parentPermissions['add_permission'],
                    //         "edit_permissions"=> $parentPermissions['edit_permission'],
                    //         "delete_permissions"=> $parentPermissions['delete_permission'],
                    //         "view_permissions"=> $parentPermissions['view_permission'],
                    //     ];
                    //     echo "Processing for ".$child;
                    //     echo "Inside Loop 2 \n";
                    //    // $this->upsertPermissions($employeeId,$chilePermissionData );
                    // }
                    //$idsToSkip[] = $child;

                }
                continue;












                
                $newPermissionsStr = $permissionData['add_permissions'].'#'.$permissionData['edit_permissions'].'#'.$permissionData['delete_permissions'].'#'.$permissionData['view_permissions'];
                $idWisePermissions[$currentMenuId] = $newPermissionsStr;
                echo " Id Wise Permissions  \n"; 
                print_r($idWisePermissions);

                echo " Parent ID = \n".$parentId;  
                if( $parentId !== '0') {
                    echo "Inside if";
                    $parentPermission = $idWisePermissions[$parentId];
                    echo " String Permissions \n"; 
                    print_r($parentPermission);
                    $parentPermissionArr = explode('#',$parentPermission);
                    echo " Array Permissions \n"; 
                    print_r($parentPermissionArr);

                    $permissionData['add_permissions'] = $parentPermissionArr[0];
                    $permissionData['edit_permissions'] = $parentPermissionArr[1];
                    $permissionData['delete_permissions'] = $parentPermissionArr[2];
                    $permissionData['view_permissions'] = $parentPermissionArr[3];
                }
                
                // echo "===preeee permissionData====";print_r($permissionData); die;
                
                $oldPermissions = MenuPermission::where('menu_id',$permissionData['menu_id'])->first()->toArray();
                $oldPermissionsStr = $oldPermissions['add_permission'].$oldPermissions['edit_permission'].$oldPermissions['delete_permission'].$oldPermissions['view_permission'];
                
                // echo "\n id processing ==".$permissionData['menu_id'];
                // echo "\n";
                // echo "----new permission first loop ---- ";  
                // echo "\n"; 
                // print_r($newPermissionsStr);
                // echo "\n";
                // echo "----old permission first loop ----";
                // echo "\n";
                // print_r($oldPermissionsStr);
                // echo "\n ";
                if($newPermissionsStr !== $oldPermissionsStr && !in_array($permissionData['menu_id'],$idsToSkip)) {
                    $this->upsertPermissions($employeeId,$permissionData);
                }
                $children = $this->getChildMenu($permissionData['menu_id'],true);
                
                // echo "===children ids for menu id ====".$permissionData['menu_id'];
                // echo "\n";
                // print_r($children);
                // echo "\n";
                // if(count($children) > 0 ) {
                    
                        foreach($children as $child) {
                            // if(!in_array($child,$idsToSkip)) {
                                $newChPermissionsStr = $newPermissionsStr;
                                $oldChPermissions = MenuPermission::where('menu_id',$child)->first()->toArray();
                                $oldChPermissionsStr = $oldChPermissions['add_permission'].$oldChPermissions['edit_permission'].$oldChPermissions['delete_permission'].$oldChPermissions['view_permission'];
    
                                echo "\n id processing ==".$child;
                                echo "\n";
                                echo "----new permission second loop ----";
                                echo "\n";  
                                print_r($newPermissionsStr);
                                echo "\n";
                                echo "----old permission second loop ----";
                                echo "\n";
                                print_r($oldPermissionsStr);
                                echo "\n";
                                // echo "===menu chilePermissionData====";print_r($chilePermissionData);
                               if(($newChPermissionsStr !== $oldChPermissionsStr) || !in_array($child,$idsToSkip)) {
                                    $chilePermissionData = [
                                        "menu_id"=> $child,
                                        "add_permissions"=> $permissionData['add_permissions'],
                                        "edit_permissions"=> $permissionData['edit_permissions'],
                                        "delete_permissions"=> $permissionData['delete_permissions'],
                                        "view_permissions"=> $permissionData['view_permissions'],
                                    ];
                                    $this->upsertPermissions($employeeId,$chilePermissionData );
                               }
                            // }
                           
                            //array_push($idsToSkip,$menuId);
                            $idsToSkip[] = $child;
                        }
                //     //}
                // }
            }
            return response()->json(['success' => 'Received employee menu permissions data']);
        }
        catch (Request $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function edit($id){
        $menuPermission=MenuPermission::where('id',$id)->first();
        return view('menus.index',['menuPermission'=>$menuPermission]);
    }

    public function update(Request $request, $id){
        // COde for updating permissions
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function delete($id)
    {
       //Code for deleting the permissions
    }
  
}
