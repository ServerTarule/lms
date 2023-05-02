<?php

namespace App\Http\Livewire;

use App\Models\DynamicMain;
use Livewire\Component;
use App\Models\Menu;

class Menus extends Component
{
    public function render()
    {

        $matchThese = [
            ['parent_id', '=', 0],
        ];
        $menus = Menu::orderby('preference', 'asc')->get();
        $menu = new Menu;
        $menuHtml = $menu->getHTML($menus);  
        $menus=Menu::all();
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
        return view('livewire.menus',["menus"=>$menus, "dynamichtml"=>$html, "nestedMenu"=>$menuHtml]);
    }
}