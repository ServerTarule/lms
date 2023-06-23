<?php

namespace App\Http\Controllers;

use App\Models\DynamicMain;
use App\Models\DynamicValue;
use App\Models\Employee;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MainMasterController extends Controller
{
    public function index($id){

        $master =DynamicMain::where('id', $id)->first();
        if(!isset($master)) {
              return view('mainmaster.index',
              [      
                  'mainmasters'=>false,    
                  'edit'=>false
              ]);
        }
        $leadStatuses = null;
        $states = null;
        $currentStateId = null;
        //Log::info($master->name);
        if(isset($master) && $master->name == 'Lead Stages') {
            $leadStatusMaster = DynamicMain::where('name', 'Lead Status')->first();
            //Log::info($leadStatusMaster);
            $leadStatuses = DynamicValue::where('parent_id', $leadStatusMaster->id)->get();
            //Log::info($leadStatuses);
        }

        if(isset($master) && $master->name == 'Cities') {
            $stateMaster = DynamicMain::where('name', 'States')->first();
            $states = DynamicValue::where('parent_id', $stateMaster->id)->get();
        }

        
        // print_r($states );
        //$mainmasters = DynamicValue::where('parent_id', $id)->get();
        //Log::info($states);
        //Log::info(count($states));
        $mainmasters=DB::table('dynamic_values as dm')->select('dm.*','pardm.name as parent_name')->leftJoin('dynamic_values as pardm', 'dm.dependent_id', '=', 'pardm.id')->get()->where('parent_id', $id);
      return view('mainmaster.index', compact('mainmasters', 'master', 'currentStateId','leadStatuses', 'states'));


/*        $master =DynamicMain::where('id', $id)->first();
        return view('mainmaster.index',compact('master'));*/
/*        $master_id = $id;
        $employee = Employee::where('master_id',null)->get();
        $mains = Employee::where('master_id',$id)->get();
        return view('mainmaster.index',compact('employee','master_id','mains'));*/
    }




    public function store(Request $request, $id) : RedirectResponse{
        $employee=Employee::where('id',$request->master)->update(['master_id'=>$id]);
        if($employee){
            return redirect()->back()->with('status', 'User Assign Successfully');
        }
        return redirect()->back()->with('error', 'Something Went Wrong');

    }

//    public function remove($id){
//        $employee=Employee::where('id',$id)->delete(['id'=>$id]);
//       // $employee=Employee::find('id',$id)->delete();
//      //  echo $employee;
//        if($employee){
//            return redirect()->back()->with('status', 'User Remove From Master Successfully');
//         }
//         return redirect()->back()->with('error', 'Something Went Wrong');
//    }

    public function destroy(Request $request) : JsonResponse {
        $id = $request->get('id');
        DynamicValue::where('id', $id)->delete();

        return response()->json(['success' => 'Received rule data']);
    }

    public function edit($masterId, $id){
        $master =DynamicMain::where('id', $masterId)->first(); 
        $leadStatuses = null;
        $states = null;
        $currentStateId = null;
        $currentLeadId = null;
        $dynaicmaster=DynamicValue::where('id',$id)->first();
        $dynaicmasterParentId = $dynaicmaster->parent_id;
        $currentDependentId =  $dynaicmaster->dependent_id;
        $dependentLabel = null;
        $parentData = null;
        if(isset($currentDependentId)) {
            $dynaicmasterDependentId = $dynaicmaster->dependent_id;
            $dynaicmasteOneLevelUp =DynamicValue::where('id',$dynaicmasterDependentId)->first();
            $parentIdOfDependentId = $dynaicmasteOneLevelUp->parent_id;
            $parentData = DynamicValue::where('parent_id', $parentIdOfDependentId)->get();
            $parentmainMaster = DynamicMain::where('id', $parentIdOfDependentId)->first();
            $dependentLabel = $parentmainMaster->name;
        }
        return view('mainmaster.index',
        [
            'dynaicmaster'=>$dynaicmaster,
            'currentDependentId'=>$currentDependentId,
            'dependentLabel'=>$dependentLabel,
            'dependentMasterData'=>$parentData,
            'master'=>$master,
            'mainmasters'=>false,    
            'edit'=>true
        ]);
    }

    public function update(Request $request,$masterId, $id){
        if(isset($request->dependentId)) {
            $dynaicmaster= DynamicValue::find($id)->update(
                [
                    'name'=>$request->name,
                    'dependent_id' => $request->dependentId
    
                ]
            );
        }
        else {
            $dynaicmaster= DynamicValue::find($id)->update(
                [
                    'name'=>$request->name,
    
                ]
            );
        }
        if($dynaicmaster){
            return redirect("/master/main/$masterId")->with('status', 'Data successfully updated.');
        }
        else{
            return redirect()->back()->with('status',`Data couldn't be updated.`);
        }
    }


     /**
     * Write code on Method
     *
     * @return response()
     */
    public function delete($id)
    {
        DynamicValue::find($id)->delete();
        return back();
    }

    public function remove($id){
        $employee=Employee::where('id',$id)->delete(['id'=>$id]);
       // $employee=Employee::find('id',$id)->delete();
      //  echo $employee;
        if($employee){
            return redirect()->back()->with('status', 'User Remove From Master Successfully');
         }
         return redirect()->back()->with('error', 'Something Went Wrong');
    }


    public function getcitiesBystate(Request $request) : JsonResponse {
        $stateId = $request->get('stateId');
        $cities = DynamicValue::where('dependent_id', $stateId)->get()->toArray();
        return response()->json(['cities' => $cities]);
    }
}
