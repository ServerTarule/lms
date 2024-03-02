<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GlobalSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class GlobalSettingsController extends Controller
{
    

    public function index()
    {
        $userDetail = auth()->user();
        $users = User::all()->where('role_id', '!=',null);
        $globalSettings = [];
        if($userDetail->role_id == $_ENV['ADMIN_ROLE']) {
            $query = "SELECT l.*, u.name as modified_by_name from 
            (SELECT gs.id, gs.setting_key, gs.setting_value, gs.setting_unit,
            gs.created_by, gs.created_at, gs.updated_by, gs.updated_at,
            users.name as created_by_name  from global_settings as gs JOIN users on gs.created_by= users.id) as l LEFT JOIN users as u ON l.updated_by = u.id;";
            $globalSettings= DB::select($query);
            return view('global-settings.index',compact( 'users','globalSettings'));
        }
        abort(403, "You are not allowed to perform this action!");

    }

    public function edit(Request $request): JsonResponse {
        $userDetail = auth()->user();
        $setting = [];
        if($userDetail->role_id == $_ENV['ADMIN_ROLE']) {
            $settingId =  $request->get('settingId');
            $setting = GlobalSetting::where('id',$settingId)->first();
            return response()->json(['setting'=>$setting]);
        }
        abort(403, "You are not allowed to perform this action!");

    }

    public function update(Request $request,$settingId): JsonResponse {
        $userDetail = auth()->user();
        if($userDetail->role_id == $_ENV['ADMIN_ROLE']) {
            $set = GlobalSetting::find($settingId);
            if(empty($set)) {
                return response()->json(['status'=>false, 'message'=>'Setting with given id does not exists.!']);
            }
            else {
                
                $request->setting_value;
                $dataToUpdate = [
                                    'setting_value'=>$request->setting_value,
                                    'updated_by'=>$userDetail['id']
                                ];
                GlobalSetting::find($settingId)->update(
                    $dataToUpdate
                );
                return response()->json(['status'=>false, 'message'=>'Settings updated.!']);
            }
        }
        else {
            abort(403, "You are not allowed to perform this action!");
        }
    }

}
