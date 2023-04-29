<?php

namespace App\Http\Controllers;

use App\Models\MenuPermission;
use Illuminate\Http\Request;

class MenusPermissionController extends Controller
{
    public function index(){
         $menupermissions=MenuPermission::all();
        return view('menus-permissions.index',compact('menupermissions'));
    }

    public function store(Request $request){
       //Sample function with no body
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
