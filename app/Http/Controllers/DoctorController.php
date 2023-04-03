<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctors;



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

}
