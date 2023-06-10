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
        $holiday = Holiday::create([
            'name'=>$request->name,
            'day'=>$request->day,
        ]);

        $holidays = Holiday::all();
        return redirect()->route('holidays.index', compact('holidays'));

    }

    public function edit(Request $request): JsonResponse {
        $holidayId =  $request->get('holidayId');
        $holiday=Holiday::where('id',$holidayId)->first()->toArray();
        return response()->json(['holiday' => $holiday]);
    }

    public function updateHoliday(Request $request,$holidayId): JsonResponse {
        $holidays = Holiday::where(['name' => $request->doctorName])->where('id', '!=' , $holidayId)->first();
        $holidayArray = (isset($holidays))?$holidays->toArray():[];
        if (count($holidayArray) == 0) {
            $holiday= Holiday::find($holidayId)->update(
                [
                    'name'=>$request->get("name"),
                    'day'=>$request->get("day")
                ]
            );
            return response()->json(['error'=>false, 'message'=>'Holiday updated successfully.']);
        }
        else {
            return response()->json(['error'=>true, 'message'=>'Holiday with this name already exists in the system, please choos other name!']);
        }
        return response()->json(['error'=>true, 'message'=>'Some Error Occured']);
    }

    public function destroy(Request $request) : JsonResponse {
        $id = $request->get('id');
        Holiday::where('id', $id)->delete();

        return response()->json(['success' => 'Received rule data']);
    }
}
