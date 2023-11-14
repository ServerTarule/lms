<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Menu;
use App\Models\MenuPermission;
use App\Models\MenuRolePermission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenusPermissionController extends Controller
{
    public function index(){
        $employees = Employee::all();
        return view('menus-permissions.index',compact("employees"));
    }

    public function rolelist() {
        $roles = Role::all();
        return view('menus-permissions.role-list',compact("roles"));
    }

    public function managerolepermission($roleId){
        $menuPermissions = [];
        $roleDetail =null;
        $role = Role::find($roleId);
        if(isset($role)) {
            $roleDetail =$role->toArray();
            $menuPermissions = DB::select('SELECT m.*,menuparent.title as parentname, t.* from ( SELECT mp.id as mId,mp.menu_id,mp.role_id,mp.add_permission,mp.edit_permission,mp.view_permission,mp.delete_permission,mp.created_at as mp_created_at  from menu_role_permissions as mp where role_id ='.$roleId.') t RIGHT JOIN menus as m on t.menu_id =  m.id LEFT JOIN menus as menuparent on m.parent_id = menuparent.id order by m.preference');
            return view('menus-permissions.role-menu-permission-edit',compact("menuPermissions","roleId","roleDetail"));
        }
        return view('menus-permissions.role-menu-permission-edit.blade',compact("menuPermissions","roleId","roleDetail"));
    }
    public function managePermission($employeeId){
        $menuPermissions = [];
        $employeeDetail =null;
        $emp = Employee::find($employeeId);
        if(isset($emp)) {
            $empUserId = $emp->user_id;
            $employeeDetailObj =  Employee::where('id', $employeeId)->first();
            $employeeDetail = null;
            if(isset($employeeDetailObj)) {
                $employeeDetail = $employeeDetailObj->toArray();
            }
            
            $menuPermissions = DB::select('SELECT m.*,menuparent.title as parentname, t.* from ( SELECT mp.id as mId,mp.menu_id,mp.employee_id,mp.add_permission,mp.edit_permission,mp.view_permission,mp.delete_permission,mp.created_at as mp_created_at  from menu_permissions as mp where employee_id ='.$empUserId.') t RIGHT JOIN menus as m on t.menu_id =  m.id LEFT JOIN menus as menuparent on m.parent_id = menuparent.id;');
            // $menuPermissions = DB::table('menus as m')->leftJoin('menus as parM', 'm.parent_id', '=', 'parM.id')->leftJoin('menu_permissions as mp', 'm.id', '=', 'mp.menu_id')->leftJoin('employees as e', 'mp.employee_id', '=', 'e.id')->where('mp.employee_id', $employeeId)
            //     ->select('m.*','parM.title as parentname', 'mp.id as mId', 'mp.menu_id', 'mp.employee_id', 'mp.add_permission', 'mp.edit_permission', 'mp.view_permission', 'mp.delete_permission', 'mp.created_at as mp_created_at', 'e.name')
            //     ->orderBy('preference','asc')->get();
            // print_r($menuPermissions);die;
            return view('menus-permissions.edit',compact("menuPermissions","employeeId","employeeDetail"));
        }
        return view('menus-permissions.edit',compact("menuPermissions","employeeId","employeeDetail"));

    }

    private function upsertPermissions($employeeId, $permissionData) {
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
        return $menu->getDescendants($menu, 0);
    }

    public function getMenuHierarchyWitoutCurrent($menuId) {
        $menu = Menu::find($menuId);
        return $menu->getDescendants($menu, $menuId);
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
        $emp = Employee::find($employeeId);
        if(isset($emp)) {
            $employeeUserId = $emp->user_id;
            // $employeeRole = $emp->role_id;
            // die;
            $menuId = $permissionData["menu_id"];
            $menu_ids = $this->getMenuHierarchyWitoutCurrent($menuId);
            // print_r($menu_ids);
            $parentId = $permissionData['parent_id'];
            // print_r($permissionData); 

            $previousPermissionsObj =  MenuPermission::where('menu_id', $menuId)->where('employee_id', $employeeUserId)->first();

            $previousPermissions = (isset($previousPermissionsObj))?$previousPermissionsObj->toArray():null;
            $childrenPermissionData = [];
            // print_r($previousPermissions); 

            // print_r($menu_ids);

            //Make all permissions inactive if view permission is made inactive
            if($permissionData['view_permissions']!== 1) {
                $permissionData['add_permissions'] = 0;
                $permissionData['edit_permissions'] = 0;
                $permissionData['delete_permissions'] = 0;
            }

            if($permissionData['add_permissions'] !== 1) {
                $childrenPermissionData ['add_permission' ] =  $permissionData['add_permissions'];
            }
            if($permissionData['edit_permissions'] !== 1) {
                $childrenPermissionData['edit_permission' ] =  $permissionData['edit_permissions'];
            }

            if($permissionData['delete_permissions'] !== 1) {
                $childrenPermissionData ['delete_permission' ] =  $permissionData['delete_permissions'];
            }

            if($permissionData['view_permissions'] !== 1) {
                $childrenPermissionData ['view_permission' ] =  $permissionData['view_permissions'];
            }

            if($parentId > 0) {
                $parentPermissionsObj = MenuPermission::where('menu_id',$parentId)->where('employee_id',$employeeUserId)->select('add_permission','edit_permission','delete_permission','view_permission')->first();
                $parentPermissions= (isset($parentPermissionsObj))?$parentPermissionsObj->toArray():null;

    //              echo "Details ==view_permissions: ".$permissionData['view_permissions'] ."----previousPermissions:".$previousPermissions['view_permission']."-----parentPermissions:".$parentPermissions['view_permission'];
                $isInvalidViewPerm = (
                    $permissionData['view_permissions'] == 1 
                    && $previousPermissions 
                    && $previousPermissions['view_permission'] != $permissionData['view_permissions'] 
                    && $parentPermissions 
                    && $parentPermissions['view_permission'] != $permissionData['view_permissions']
                
                );

                // echo "*****isInvalidViewPerm***** ==".$isInvalidViewPerm;
                $isInvalidAddPerm = (
                                        $permissionData['add_permissions'] == 1 
                                        && $previousPermissions 
                                        && $previousPermissions['add_permission'] != $permissionData['add_permissions'] 
                                        && $parentPermissions 
                                        &&  $parentPermissions['add_permission'] != $permissionData['add_permissions']
                                    
                                    );
                
                $isInvalidEditPerm = (
                                        $permissionData['edit_permissions'] == 1
                                        && $previousPermissions
                                        && $previousPermissions['edit_permission'] != $permissionData['edit_permissions'] 
                                        && $parentPermissions 
                                        && $parentPermissions['edit_permission'] != $permissionData['edit_permissions']
                                    );

                $isInvalidDeletePerm = (
                                        $permissionData['delete_permissions'] == 1
                                        && $previousPermissions
                                        && $previousPermissions['delete_permission'] != $permissionData['delete_permissions'] 
                                        && $parentPermissions 
                                        && $parentPermissions['delete_permission'] != $permissionData['delete_permissions']
                                    );
        
            

                if(
                    $isInvalidViewPerm         
                    ) {
                    throw new \Error('Please make sure view permission  for parent menu is same.');
                }
                else if(
                    $isInvalidAddPerm               
                    ) {
                    throw new \Error('Please make sure add permission  for parent menu is  same.');
                }
                else if(
                    $isInvalidEditPerm               
                    ) {
                    throw new \Error('Please make sure edit permission  for parent menu is same.');
                }
                else if(
                    $isInvalidDeletePerm               
                    ) {
                    throw new \Error('Please make sure delete permission  for parent menu is same.');
                }

            }

            MenuPermission::unguard();
            MenuPermission::updateOrCreate(
                [
                    'employee_id' => $employeeUserId, 'menu_id' => $menuId
                ],
                [
                    'add_permission' => $permissionData['add_permissions'],
                    'edit_permission' => $permissionData['edit_permissions'],
                    'delete_permission' => $permissionData['delete_permissions'],
                    'view_permission' => $permissionData['view_permissions'],
                
                ]);
            MenuPermission::reguard();
        
            foreach($menu_ids as $menu_id) {
                $previousPermissionsSubMenu = [
                    'add_permission'=>0,
                    'edit_permission'=>0,
                    'delete_permission'=>0,
                    'view_permission'=>0,
                ];
                $previousPermissionsSubMenuObj =  MenuPermission::where('menu_id', $menu_id)->where('employee_id', $employeeId)->first();
                $previousPermissionsSubMenu = isset($previousPermissionsSubMenuObj)?$previousPermissionsSubMenuObj->toArray():$previousPermissionsSubMenu;
                MenuPermission::unguard();
                MenuPermission::updateOrCreate(
                    [
                        'employee_id' => $employeeUserId, 'menu_id' => $menu_id
                    ],
                    [
                        'add_permission' => isset($childrenPermissionData['add_permission'])?$childrenPermissionData['add_permission']:$previousPermissionsSubMenu['add_permission'],
                        'edit_permission' => isset($childrenPermissionData['edit_permission'])?$childrenPermissionData['edit_permission']:$previousPermissionsSubMenu['edit_permission'],
                        'delete_permission' => isset($childrenPermissionData['delete_permission'])?$childrenPermissionData['delete_permission']:$previousPermissionsSubMenu['delete_permission'],
                        'view_permission' => isset($childrenPermissionData['view_permission'])?$childrenPermissionData['view_permission']:$previousPermissionsSubMenu['view_permission'],
                    
                    ]);
                MenuPermission::reguard();
            }
            return response()->json(['success' => 'Received employee menu permissions data']);
        }
        
    }

    public function setSinglePermissionByRole(Request $request){
        $roleId = $request->get('roleId');
        $permissionData = $request->get('permissionData');
        $permissionData = json_decode( $permissionData, true );
        // print_r($permissionData);die;
        try {
            $this->processSinglePermissionByRole($permissionData, $roleId );
        }
        catch (Request $e) {
            throw new \Exception($e->getMessage());
        }
        return response()->json(['message'=>'Employee menu permissions data updated successfuly.' ]);
    }

    private function processSinglePermissionByRole($permissionData, $roleId) {
        $role = Role::find($roleId);
        if(isset($role)) {
            // $employeeUserId = $emp->user_id;
            // $employeeRole = $emp->role_id;
            // die;
            $menuId = $permissionData["menu_id"];
            $menu_ids = $this->getMenuHierarchyWitoutCurrent($menuId);
            // print_r($menu_ids);
            $parentId = $permissionData['parent_id'];
            // print_r($permissionData); 

            $previousPermissionsObj =  MenuRolePermission::where('menu_id', $menuId)->where('role_id', $roleId)->first();

            $previousPermissions = (isset($previousPermissionsObj))?$previousPermissionsObj->toArray():null;
            $childrenPermissionData = [];
            // print_r($previousPermissions); 

            // print_r($menu_ids);

            //Make all permissions inactive if view permission is made inactive
            if($permissionData['view_permissions']!== 1) {
                $permissionData['add_permissions'] = 0;
                $permissionData['edit_permissions'] = 0;
                $permissionData['delete_permissions'] = 0;
            }

            if($permissionData['add_permissions'] !== 1) {
                $childrenPermissionData ['add_permission' ] =  $permissionData['add_permissions'];
            }
            if($permissionData['edit_permissions'] !== 1) {
                $childrenPermissionData['edit_permission' ] =  $permissionData['edit_permissions'];
            }

            if($permissionData['delete_permissions'] !== 1) {
                $childrenPermissionData ['delete_permission' ] =  $permissionData['delete_permissions'];
            }

            if($permissionData['view_permissions'] !== 1) {
                $childrenPermissionData ['view_permission' ] =  $permissionData['view_permissions'];
            }

            if($parentId > 0) {
                $parentPermissionsObj = MenuRolePermission::where('menu_id',$parentId)->where('role_id',$roleId)->select('add_permission','edit_permission','delete_permission','view_permission')->first();
                $parentPermissions= (isset($parentPermissionsObj))?$parentPermissionsObj->toArray():null;

    //              echo "Details ==view_permissions: ".$permissionData['view_permissions'] ."----previousPermissions:".$previousPermissions['view_permission']."-----parentPermissions:".$parentPermissions['view_permission'];
                $isInvalidViewPerm = (
                    $permissionData['view_permissions'] == 1 
                    && $previousPermissions 
                    && $previousPermissions['view_permission'] != $permissionData['view_permissions'] 
                    && $parentPermissions 
                    && $parentPermissions['view_permission'] != $permissionData['view_permissions']
                
                );

                // echo "*****isInvalidViewPerm***** ==".$isInvalidViewPerm;
                $isInvalidAddPerm = (
                                        $permissionData['add_permissions'] == 1 
                                        && $previousPermissions 
                                        && $previousPermissions['add_permission'] != $permissionData['add_permissions'] 
                                        && $parentPermissions 
                                        &&  $parentPermissions['add_permission'] != $permissionData['add_permissions']
                                    
                                    );
                
                $isInvalidEditPerm = (
                                        $permissionData['edit_permissions'] == 1
                                        && $previousPermissions
                                        && $previousPermissions['edit_permission'] != $permissionData['edit_permissions'] 
                                        && $parentPermissions 
                                        && $parentPermissions['edit_permission'] != $permissionData['edit_permissions']
                                    );

                $isInvalidDeletePerm = (
                                        $permissionData['delete_permissions'] == 1
                                        && $previousPermissions
                                        && $previousPermissions['delete_permission'] != $permissionData['delete_permissions'] 
                                        && $parentPermissions 
                                        && $parentPermissions['delete_permission'] != $permissionData['delete_permissions']
                                    );        


                if(
                    $isInvalidViewPerm         
                    ) {
                    throw new \Error('Please make sure view permission  for parent menu is same.');
                }
                else if(
                    $isInvalidAddPerm               
                    ) {
                    throw new \Error('Please make sure add permission  for parent menu is  same.');
                }
                else if(
                    $isInvalidEditPerm               
                    ) {
                    throw new \Error('Please make sure edit permission  for parent menu is same.');
                }
                else if(
                    $isInvalidDeletePerm               
                    ) {
                    throw new \Error('Please make sure delete permission  for parent menu is same.');
                }

            }

            MenuRolePermission::unguard();
            MenuRolePermission::updateOrCreate(
                [
                    'role_id' => $roleId, 'menu_id' => $menuId
                ],
                [
                    'add_permission' => $permissionData['add_permissions'],
                    'edit_permission' => $permissionData['edit_permissions'],
                    'delete_permission' => $permissionData['delete_permissions'],
                    'view_permission' => $permissionData['view_permissions'],
                
                ]);
            MenuRolePermission::reguard();
        
            foreach($menu_ids as $menu_id) {
                $previousPermissionsSubMenu = [
                    'add_permission'=>0,
                    'edit_permission'=>0,
                    'delete_permission'=>0,
                    'view_permission'=>0,
                ];
                $previousPermissionsSubMenuObj =  MenuRolePermission::where('menu_id', $menu_id)->where('role_id', $roleId)->first();
                $previousPermissionsSubMenu = isset($previousPermissionsSubMenuObj)?$previousPermissionsSubMenuObj->toArray():$previousPermissionsSubMenu;
                MenuRolePermission::unguard();
                MenuRolePermission::updateOrCreate(
                    [
                        'role_id' => $roleId, 'menu_id' => $menu_id
                    ],
                    [
                        'add_permission' => isset($childrenPermissionData['add_permission'])?$childrenPermissionData['add_permission']:$previousPermissionsSubMenu['add_permission'],
                        'edit_permission' => isset($childrenPermissionData['edit_permission'])?$childrenPermissionData['edit_permission']:$previousPermissionsSubMenu['edit_permission'],
                        'delete_permission' => isset($childrenPermissionData['delete_permission'])?$childrenPermissionData['delete_permission']:$previousPermissionsSubMenu['delete_permission'],
                        'view_permission' => isset($childrenPermissionData['view_permission'])?$childrenPermissionData['view_permission']:$previousPermissionsSubMenu['view_permission'],
                    
                    ]);
                MenuRolePermission::reguard();
            }
            return response()->json(['success' => 'Received menu permissions data for role']);
        }
        
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
                    // echo "Processing for ".$currentMenuId;
                    // echo "Inside if 1    children \n";
                    $this->upsertPermissions($employeeId,$permissionData);
                $children = $this->getChildMenu($currentMenuId,true);
                if(count($children) > 0 && $parentId == 0) {
                    foreach($children as $child) {
                        $chilePermissionData = [
                            "menu_id"=> $child,
                            "add_permissions"=> $permissionData['add_permissions'],
                            "edit_permissions"=> $permissionData['edit_permissions'],
                            "delete_permissions"=> $permissionData['delete_permissions'],
                            "view_permissions"=> $permissionData['view_permissions'],
                        ];
                        // echo "Processing for ".$child;
                        // echo "Inside Loop 1 \n";
                        $this->upsertPermissions($employeeId,$chilePermissionData );
                        $idsToSkip[] = $child;
                    }
                }
                else if(count($children) > 0 && $parentId !== 0 ||  $oldPermissionsStr !== $newPermissionsStr) {
                //TO DO

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
                                
                $oldPermissions = MenuPermission::where('menu_id',$permissionData['menu_id'])->first()->toArray();
                $oldPermissionsStr = $oldPermissions['add_permission'].$oldPermissions['edit_permission'].$oldPermissions['delete_permission'].$oldPermissions['view_permission'];
                if($newPermissionsStr !== $oldPermissionsStr && !in_array($permissionData['menu_id'],$idsToSkip)) {
                    $this->upsertPermissions($employeeId,$permissionData);
                }
                $children = $this->getChildMenu($permissionData['menu_id'],true);
                foreach($children as $child) {
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
                    $idsToSkip[] = $child;
                }
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
