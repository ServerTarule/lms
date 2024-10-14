<?php

namespace App\Http\Livewire;

use App\Models\DynamicMain;
use Livewire\Component;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Menus extends Component
{
    public function render()
    {

        $menus =[];
        $html="";
        $nestedMenu="";
        $user = Auth::user();
        if(isset($user) && !empty($user->toArray())) {
            $roleId = $user->role_id;
            $userArray= $user->toArray();
            $matchThese = [
                ['parent_id', '=', 0],
            ];
            $menus = Menu::where('deleted','!=',1)->orderby('preference', 'asc')->get();
            $query = "SELECT m.*, mp.menu_id, mp.role_id,mp.add_permission,mp.edit_permission,mp.view_permission,mp.delete_permission from menus m INNER JOIN menu_role_permissions mp  on m.id = mp.menu_id 
            where mp.role_id = $roleId and mp.view_permission = '1' order by preference asc";
            $result = DB::select($query);
            $menuPermittendForRole = json_decode(json_encode($result), true);     
            $menu = new Menu;
            if( $roleId == 6) {//
                $menuHtml = (!empty($menus->toArray()))?$menu->getHTML($menus):'';  
            }
            else {
                $menuHtml = (!empty($menuPermittendForRole))?$menu->getHTML($menuPermittendForRole):'';  
            }
            
            $html = '
            <ul class="sidebar-menu">
                <li class="active">
                    <a href="/"><i class="fa fa-tachometer"></i><span>Dashboard</span>
                        <span class="pull-right-container">
                        </span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-users"></i><span>Menu</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="/menu">Create Menu</a>
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-trash"></i><span>Menu</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="/menu">child Menu</a></li>
                                </ul>
                            </li>
                        </li>
                    </ul>
                </li>
            </ul>
            ';
        }
        // echo "---#####".$menuHtml."#########";
        // echo "Menu Html ==".$menuHtml; die("died");
        //return view('livewire.menus',["menus"=>$menus, "dynamichtml"=>$html, "nestedMenu"=>$menuHtml]);
        return view('livewire.menus',["menus"=>$menus, "dynamichtml"=>$html, "nestedMenu"=>$menuHtml]);
    }
}
