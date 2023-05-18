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

    public function store(Request $request) : RedirectResponse {

        $template = Template::create([
            'type'=>$request->templateType,
            'name'=>$request->templateName,
            'message'=>$request->templateMessage,
            'subject'=>$request->templateEmailSubject,
            'body'=>$request->templateEmailBody,
        ]);

        $templates = Template::all();
        return redirect()->route('templates.index', compact('templates'));

    }

    public function destroy(Request $request) : JsonResponse {
        $id = $request->get('id');
        Template::where('id', $id)->delete();

        return response()->json(['success' => 'Received rule data']);
    }

}
