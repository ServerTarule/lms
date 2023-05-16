<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use App\Models\Template;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HolidayController extends Controller
{
    public function index(){
        $holidays = Holiday::all();
        return view('holidays.index',compact('holidays'));
    }

    public function store(Request $request) {

//        Log::info($request->name);
//        Log::info($request->day);

        $holiday = Holiday::create([
            'name'=>$request->name,
            'day'=>$request->day,
        ]);

        $holidays = Holiday::all();
        return redirect()->route('holidays.index', compact('holidays'));

    }

    public function destroy(Request $request) : JsonResponse {
        $id = $request->get('id');
        Holiday::where('id', $id)->delete();

        return response()->json(['success' => 'Received rule data']);
    }
}
