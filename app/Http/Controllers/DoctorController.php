<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Doctors;
use Illuminate\Support\Facades\Log;


class DoctorController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctors = Doctors::all();
        return view('doctors.index',compact('doctors'));
    }

    public function addDoctors(Request $request)
    {
        if (!$doctors = Doctors::where(['name' => $request->doctorName])->first()) {
            $doctors = Doctors::create(['name' => $request->doctorName]);
            return redirect('doctors')->with('status', 'Doctor Created Successfully');
        }
        return redirect('doctors')->with('error', 'Doctor with this name already exists in the system, please choos other name!');
    }

    
    public function edit(Request $request): JsonResponse {
        $doctorId =  $request->get('doctorId');
        $doctor=Doctors::where('id',$doctorId)->first();
        return response()->json(['doctor' => $doctor]);
    }

    public function updateDoctor(Request $request,$doctorId): JsonResponse {
        $doctors = Doctors::where(['name' => $request->doctorName])->where('id', '!=' , $doctorId)->first();
        $doctorsArray = (isset($doctors))?$doctors->toArray():[];
        if (count($doctorsArray) == 0) {
            $doctor= Doctors::find($doctorId)->update(
                [
                    'name'=>$request->get("doctorName")
                ]
            );
            return response()->json(['error'=>false, 'message'=>'Doctor updated successfully.']);
        }
        else {
            return response()->json(['error'=>true, 'message'=>'Doctor with this name already exists in the system, please choos other name!']);
        }
        return response()->json(['error'=>true, 'message'=>'Some Error Occured']);
    }


    public function destroy(Request $request) : JsonResponse {
        $id = $request->get('id');
        Log::info("*** Delete Doctor ***");
        Log::info($id);
        Doctors::where('id', $id)->delete();

        return response()->json(['success' => 'Received rule data']);
    }

}
