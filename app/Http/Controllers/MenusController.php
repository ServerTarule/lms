<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenusController extends Controller
{
    public function index(){
         $menus=Menu::all();
        return view('menus.index',compact('menus'));
    }

    public function store(Request $request){
        $unique = Menu::where('title',$request->title)->orWhere('url', $request->url)->first();
        if($unique){
            return redirect()->back()->with('error','Menu with this name or url already Exist');
        }
         
        $menuData=Menu::create([
            'title'=>$request->title,
            'parent_id'=>$request->parent_id,
            'class'=>$request->class,
            'icon'=>$request->icon,
            'url'=>$request->url,
        ]);
        if($menuData){
            return redirect()->back()->with('status','Menu Added Successfully');
        }
        return redirect()->back()->with('error','Something Went Wrong');

    }

    public function edit($id){
        $menu=Menu::where('id',$id)->first();
        $parentMenus  =Menu::all();
        return view('menus.index',['menu'=>$menu,'menus'=> false,'parentMenus'=>$parentMenus]);
    }

    public function update(Request $request, $id){
        $matchThese = [
            ['title', '=', "asdasdas".$request->title],
            ['id', '<>', $id],
        ];
        $unique = Menu::where($matchThese)->orWhere('url', '=', $request->url)->first();

        echo "<pre>";print_r($unique);die;
        if($unique){
            return redirect()->back()->with('error','Menu Already Exist');
        }

        $master= Menu::find($id)->update(
            [
                'title'=>$request->title,
                'class'=>$request->class,
                'icon'=>$request->icon,
                'url'=>$request->url,
                'parent_id'=>$request->parent_id
            ]
        );
        if($master){
            return redirect()->route('menus')->with('status','Menu Updated Successfully');
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function delete($id)
    {
        Menu::find($id)->delete();
        return back();
    }
  
}
