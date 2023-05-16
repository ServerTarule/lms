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
        if (!$doctors = Doctors::where(['name' => $request->addDoctor])->first()) {
            $doctors = Doctors::create(['name' => $request->addDoctor]);
            return redirect('doctors')->with('status', 'Doctor Created Successfully');
        }
        return redirect('doctors')->with('error', 'Somethinge went wrong !');
    }
//    public function deletedoctors($id)
//    {
//
//
//        if (!$doctors =Doctors:: find($id)->firstorfail()->delete()) {
//
//            return redirect('doctors')->with('status', 'Doctor Deleted Successfully');
//        }
//        return redirect('doctors')->with('error', 'Somethinge went wrong !');
//
//    }

    public function destroy(Request $request) : JsonResponse {
        $id = $request->get('id');
        Log::info("*** Delete Doctor ***");
        Log::info($id);
        Doctors::where('id', $id)->delete();

        return response()->json(['success' => 'Received rule data']);
    }

}
