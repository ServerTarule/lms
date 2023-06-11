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

    public function store(Request $request): JsonResponse {
        $holidays = Holiday::where(['day' => $request->get("day"),])->first();
        $holidayArray = (isset($holidays))?$holidays->toArray():[];
        if (count($holidayArray) == 0) {
            $holiday = Holiday::create([
                'name'=>$request->name,
                'day'=>$request->day,
            ]);
            return response()->json(['error'=>false, 'message'=>'Holiday added successfully.']);
        }
        else {
            return response()->json(['error'=>true, 'message'=>'Holiday at this day/date already exists in the system, please choose other date!']);
        }
        return response()->json(['error'=>true, 'message'=>'Some Error Occured']);

    }

    public function edit(Request $request): JsonResponse {
        $holidayId =  $request->get('holidayId');
        $holiday=Holiday::where('id',$holidayId)->first()->toArray();
        return response()->json(['holiday' => $holiday]);
    }

    public function updateHoliday(Request $request,$holidayId): JsonResponse {
        $holidays = Holiday::where(['day' => $request->get("day"),])->where('id', '!=' , $holidayId)->first();
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
            return response()->json(['error'=>true, 'message'=>'Holiday at this day/date already exists in the system, please choose other date!']);
        }
        return response()->json(['error'=>true, 'message'=>'Some Error Occured']);
    }

    public function destroy(Request $request) : JsonResponse {
        $id = $request->get('id');
        Holiday::where('id', $id)->delete();

        return response()->json(['success' => 'Received rule data']);
    }
}
