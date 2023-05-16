<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Center;
use App\Models\Doctors;
use App\Models\City;
use App\Models\State;
use Illuminate\Support\Facades\Log;

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

    public function destroy(Request $request) : JsonResponse {
        $id = $request->get('id');
        Center::where('id', $id)->delete();

        return response()->json(['success' => 'Received rule data']);
    }


}

