<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() : View
    {
        $leads = Lead::all();
        $leadsCount = count($leads);
        $user = Auth::user();
        $userId = $user?$user->id:0;
        $userAssignedLead = [];
        $userAssignedLeadsCount = 0;
        if(isset($user)) {
            $userArray= $user->toArray();
            $roleId = $userArray['role_id'];
        }
        if($userId){
            $currentEmployee=Employee::where('user_id',$userId)->get();
            // print_r($currentEmployee);
            if(count($currentEmployee) > 0) {
                $currentEmployeeId=$currentEmployee[0]->id;
                $userAssignedLeads = Lead::where("employee_id",$currentEmployeeId)->get();
                $userAssignedLeadsCount = count($userAssignedLeads);
            }
            
        }
        return view('home', compact('leadsCount','userAssignedLeadsCount','roleId'));
        //
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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
