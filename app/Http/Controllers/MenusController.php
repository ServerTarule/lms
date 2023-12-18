<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuRolePermission;
use App\Models\MenuUrl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class MenusController extends Controller
{
    public function index(){
        // $menus=Menu::all();
        $menus=DB::table('menus as m')->select('m.*','parM.title as parent_name')->leftJoin('menus as parM', 'm.parent_id', '=', 'parM.id')->get();       
        $menuWithTopPref=Menu::where([])->orderBy('preference','desc')->first();

        $menuurls=MenuUrl::all();
        if(isset($_GET['test']) && $_GET['test'] == 1) {
            $menuurls= [];
        }
        // print_r($menuurls);
        return view('menus.index',compact('menus','menuWithTopPref','menuurls'));
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

    public function getMenuHierarchy($menuId) {
        $menu = Menu::find($menuId);
        $menuHirarichy = $menu->getDescendants($menu, 0);
        // print_r($menuHirarichy);
        return $menuHirarichy;
    }
    public function edit($id){
        $menu=Menu::where('id',$id)->first();
        $this->getMenuHierarchy($id);
        $parentMenus  =Menu::all();
        $menuurls=MenuUrl::all();
        if(isset($_GET['test']) && $_GET['test'] == 1) {
            $menuurls= [];
        }
        return view('menus.index',['menu'=>$menu,'menus'=> false,'parentMenus'=>$parentMenus, 'menuurls'=>$menuurls]);
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
        $class = $request->class;
        $icon = $request->icon;
        $menu= Menu::find($id)->update(
            [
                'title'=>$request->title,
                'class'=>(isset($class))? $class : "",
                'icon'=>(isset($icon))? $icon : "",
                'url'=>$request->url,
                'parent_id'=>$request->parent_id,
                'preference'=>$request->preference,
            ]
        );
        if($menu){
            return redirect()->route('menus')->with('status','Menu Updated Successfully');
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function delete($id): JsonResponse {
        $menuHierarchy = $this->getMenuHierarchy($id);
        try{
            Menu::whereIn('id', $menuHierarchy)->delete();
            $this->updateMenuPermissionsByMenuId($menuHierarchy);
            return response()->json(['status'=>true, 'message'=>'Menu(s) deleted successfuly..']);
        }
        catch(Throwable $e){
            return response()->json(['status'=>false, 'message'=>'Error occurred while deleting menu(s) !! Error: '.$e->getMessage()]);
        }
    }
    public function togglemenutatus(Request $request,$menuId): JsonResponse {
        try {
            $menu = Menu::find($menuId);
            if(!isset($menu) && empty($menu)) {
                return response()->json(['status'=>false, 'message'=>'Menu with given id does not exists.!']);
            }
            else {
                $menuHierarchy = $this->getMenuHierarchy($menuId);
                $statusStr = "de-activated";
                $deleted = 1;
                if($request->deleted == false || $request->deleted == "false") {
                    $statusStr = "activated";
                    $deleted= 0;
                }
                //Toggle Menu
                $menuUpdateStatus =DB::table('menus')->whereIn('id', $menuHierarchy)->update(['deleted' => $deleted]);
                //Deactivate Menu Permission For All Users In Case Menu Is Deactivated
                $this->updateMenuPermissionsByMenuId($menuHierarchy);
                if($menuUpdateStatus){
                    return response()->json(['status'=>true, 'message'=>"Menu $statusStr successfully"]);
                }
            }
        }
        catch(Throwable $e){
            return response()->json(['status'=>false, 'message'=>'Some Error Occured, Error: '.$e->getMessage()]);
        }
       
        return response()->json(['status'=>false, 'message'=>'Some Error Occured']);
    }

    private function updateMenuPermissionsByMenuId($menuHierarchy) {
        $menuPemissionRowIds =MenuRolePermission::all()->whereIn('menu_id',$menuHierarchy)->pluck('id');;
        if(!empty($menuPemissionRowIds)) {
            $menuPemissionRowIds = $menuPemissionRowIds->toArray();
        }
        $permissionData = [
            "add_permission"=>0,
            "edit_permission"=>0,
            "delete_permission"=>0,
            "view_permission"=>0,
        ];
        MenuRolePermission::whereIn('id', $menuPemissionRowIds)->update($permissionData);        
    }
    public function deactivate(Request $request, $id){
        // die("I am deactivating");
        $menu= Menu::find($id)->update(
            [
                'deleted'=>$request->deleted
            ]
        );
        if($menu){
            return redirect()->route('menus')->with('status','Menu Updated Successfully');
        }
    }


    public function addmenuurls() {
        try{
            $menus=Menu::all();
            if(!empty($menus)) {
                $menus = $menus->toArray();
                $query = 'Insert into `menu_urls` (`name`, `url`) VALUES ';
                $count = 0;
                $menuUrlArrFinal = [];
                foreach($menus as $menu) {
                    $count++;
                    $name = $menu['title'];
                    $url = $menu['url'];
                    $menuUrlArr['name'] = $name;
                    $menuUrlArr['url'] = $url;
                    $menuUrlArrFinal[]=$menuUrlArr;
                    if($count == count($menus)) {
                        $query = $query ."( '$name' , '$url')";
                    }
                    else {
                        $query = $query ."( '$name' , '$url'),";
                    }
                }
    
               
                DB::table('menu_urls')->insert(
                    $menuUrlArrFinal
                );
                $query .= ';';
            }
    
            echo "\n <span style='color:green; text-align:center'> <h1>Successfully Added!! </h1></span>";  
            echo "\n <span style='color:green; text-align:center'> <h3>Query to be executedn In DB For Adding Menu URL : </h3> </span>".$query."\n";
            echo "\n <span style='color:green; text-align:center'> <h3>Final Array To be Pushed Into DB </h3> </span> \n ";
            echo "<pre>";print_r($menuUrlArrFinal);
            echo "</pre>";    
        }
        catch(Throwable $e){
            echo "\n <span style='color:red; text-align:center'> <h1>Error Occurred!! </h1></span>";
            echo "\n <b> <h3>Error Message : </h3></b> \n <span style='color:red'> ".$e->getMessage()."</span>";
        }
        
    }
  
}
