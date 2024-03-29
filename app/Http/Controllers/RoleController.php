<?php

namespace App\Http\Controllers;

use App\Models\DynamicMain;
use App\Models\Leaves;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $roles = Role::all();
        return view('role', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$role = Role::where(['name' => $request->name])->first()) {
            $role = Role::create(['name' => $request->name]);
            return redirect('role')->with('status', 'Role Created Successfully');
        }
        return redirect('role')->with('error', 'Somethinge went wrong !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $role = Role::where('id', $id)->first();

        return view('role', ['role' => $role, 'roles' => false]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($role = Role::where('id', $request->id)
            ->update(['name' => $request->name])
        ) {

            return redirect('role')->with('status', 'Role Updated Successfully');
        }
        return redirect('role')->with('error', 'Somethinge went wrong !');
    }


    public function destroy(Request $request) : JsonResponse {
        $user = Auth::user();
        $userId = $user?$user->id:0;
        $roleId = $user?$user->role_id:0;
        
       $id = $request->get('id');
    //    echo "Passed ==".$id."----current --".$roleId; die;
        if($id == $roleId) {
            return response()->json(['status' => false, 'message'=>'You can;t delete your own role, with which you are logged in!']);
        }
        else {
            Role::where('id', $id)->delete();
            return response()->json(['success' => true, 'message'=>'Data successfully deleted!']);
        }
        
    }

    public function assign()
    {


    //  $role= User::find(2);
    //  $role->hasExactRoles(Role::all());
    // //dd($role->roles);
    // $roles=$role->roles;
    // dd($roles);

    $role=Role::find(6)->givePermissionTo('create designation');
    $role=Role::find(6)->givePermissionTo('read designation');
    $role=Role::find(6)->givePermissionTo('update designation');
    $role=Role::find(6)->givePermissionTo('delete designation');

    $role=Role::find(6)->givePermissionTo('create leaves');
    $role=Role::find(6)->givePermissionTo('read leaves');
    $role=Role::find(6)->givePermissionTo('update leaves');
    $role=Role::find(6)->givePermissionTo('delete leaves');

    // // $role=Role::find(6);

    // dd($role->permissions);

    // $user=User::role()->get();
    // dd($user[1]->roles);
    // dd($role);
    // $main=DynamicMain::where('master',1)->get()->sortBy('name');
    //     dd($main);
    }
}
