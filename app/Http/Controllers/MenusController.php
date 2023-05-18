<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenusController extends Controller
{
    public function index(){
        // $menus=Menu::all();
        $menus=DB::table('menus as m')->select('m.*','parM.title as parent_name')->leftJoin('menus as parM', 'm.parent_id', '=', 'parM.id')->get();
       
        // print_r($menus->toArray());
        $menuWithTopPref=Menu::where([])->orderBy('preference','desc')->first();
        //  print_r($menuWithTopPrefone->toArray());
        return view('menus.index',compact('menus','menuWithTopPref'));
    }

    public function store(Request $request){
        $unique = Menu::where('title',$request->title)->where('url', $request->url)->first();
        if($unique){
            return redirect()->back()->with('error','Menu with this name or url already Exist');
        }
        $class = $request->class;
        $icon = $request->icon;
        $menuData=Menu::create([
            'title'=>$request->title,
            'parent_id'=>$request->parent_id,
            'class'=>(isset($class ))? $class : "",
            'icon'=>(isset($icon ))? $icon : "",
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
                'class'=>(isset($class ))? $class : "",
                'icon'=>(isset($icon ))? $icon : "",
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
