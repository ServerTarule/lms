<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Center;
use App\Models\Doctors;
use App\Models\City;
use App\Models\State;

class CenterController extends Controller
{
    //
    public function index()
    {
        $centers = Center::all();
        $doctor=Doctors::all();
        $city=City::all();
        $state = State::all();
      
        return view('center.index',compact( 'centers','doctor','city','state'));
    }

    public function addCenter(Request $request){
        
    $centers=Center::create([
            'centerDetails'=>$request->centerDetails,
            'mobile'=>$request->mobile,
            'alternateMobile'=>$request->alternateMobile,
            'state'=>$request->state,
            'city'=>$request->city,
            'ownerName'=>$request->ownerName,
            'EmailId'=>$request->EmailId,
        ]);
        if($centers){
            return redirect('centers')->with('status', 'Doctor Created Successfully');

        }
        return redirect('centers')->with('status', 'Some Error Occured');
    }

}

