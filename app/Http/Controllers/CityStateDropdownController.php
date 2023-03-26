<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityStateDropdownController extends Controller
{
    public function city(Request $request) {
        $data['cities'] = City::where('state_id', $request->state_id)->get(['name','id']);
        return response()->json($data);
    }
}
