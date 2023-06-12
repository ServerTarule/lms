<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Template;
use Illuminate\Support\Facades\Log;

class TemplateController extends Controller
{
    //
    public function index()
    {
        $templates = Template::all();

        return view('templates.index',compact( 'templates'));
    }

    public function store(Request $request) : JsonResponse {
        $templates = Template::where(['name' => $request->templateName, 'type'=>$request->templateType])->first();
        $templateArray = (isset($templates))?$templates->toArray():[];
        if (count($templateArray) == 0) {
            $template = Template::create([
                'name'=>$request->templateName,
                'type'=>$request->templateType,
                'subject'=>($request->templateType == "Email")?$request->templateEmailSubject:"",
                'message'=>($request->templateType == "Email")?$request->templateEmailBody:$request->templateMessage, 
            ]);
            return response()->json(['error'=>false, 'message'=>'Template added successfully.']);
        }
        else {
            return response()->json(['error'=>true, 'message'=>'Template with this name already exists in the system, please choose other name!']);
        }
        return response()->json(['error'=>true, 'message'=>'Some Error Occured']);

    }


    public function edit(Request $request): JsonResponse {
        $templateId =  $request->get('templateId');
        $template=Template::where('id',$templateId)->first()->toArray();
        return response()->json(['template' => $template]);
    }

    public function updateTemplate (Request $request,$templateId): JsonResponse {
        $templates = Template::where(['name' => $request->templateName, 'type'=>$request->templateType])->where('id', '!=' , $templateId)->first();
        $templateArray = (isset($templates))?$templates->toArray():[];
        if (count($templateArray) == 0) {
            $template= Template::find($templateId)->update(
                [
                    'name'=>$request->templateName,
                    'type'=>$request->templateType,
                    'subject'=>($request->templateType == "Email")?$request->templateEmailSubject:"",
                    'message'=>($request->templateType == "Email")?$request->templateEmailBody:$request->templateMessage, 
                ]
            );
            return response()->json(['error'=>false, 'message'=>'Template updated successfully.']);
        }
        else {
            return response()->json(['error'=>true, 'message'=>'Template with this name already exists in the system, please choose other name!']);
        }
        return response()->json(['error'=>true, 'message'=>'Some Error Occured']);
    }

    public function destroy(Request $request) : JsonResponse {
        $id = $request->get('id');
        Template::where('id', $id)->delete();

        return response()->json(['success' => 'Received rule data']);
    }

}
