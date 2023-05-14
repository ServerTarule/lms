<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenusController extends Controller
{
    public function index(){
        $menus=Menu::all();
        $menuWithTopPref=Menu::where([])->orderBy('preference','desc')->first();
        return view('menus.index',compact('menus','menuWithTopPref'));
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
            'preference'=>$request->preference
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
            ['title', '=', $request->title],
            ['id', '<>', $id],
            ['url', '=', $request->url]
        ];
        $unique = Menu::where($matchThese)->first();
        if($unique){
            return redirect()->back()->with('error','Menu Already Exist');
        }
        $master= Menu::find($id)->update(
            [
                'title'=>$request->title,
                'class'=>$request->class,
                'icon'=>$request->icon,
                'url'=>$request->url,
                'parent_id'=>$request->parent_id,
                'preference'=>$request->preference,
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
