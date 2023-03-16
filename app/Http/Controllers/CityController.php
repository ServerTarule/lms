<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class CityController extends Controller
{
    public function index(){
        $cities=City::all();
        $states=State::all();
        return view('cities.index',compact('cities','states'));
    }
}
