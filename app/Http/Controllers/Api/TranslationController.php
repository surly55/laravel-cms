<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TranslationRequest;
use App\Models\Translation;

use Illuminate\Http\Request;

class TranslationController extends Controller
{
    public function index(Request $request)
    {
        $query = Translation::query();
        if($request->has('site')) {
            $query->where('site_id', $request->get('site'));
        }

        $translations = $query->get();

        return response()->json($translations);
    }

    public function store(Request $request)
    {
        if($request->has('translations')) {
            $site = $request->get('site_id');
            foreach($request->get('translations') as $_translation) {
                $translation = Translation::where('key', $_translation['key'])->where('site_id', $site)->first();
                if($translation) {
                    $translation->fill($_translation);
                } else {
                    $translation = new Translation($_translation);
                    $translation->site_id = $site;
                }
                $translation->save();
            }
        } else {
            $translation = new Translation($request->all());
            $translation->save();    
        }

        return response(null, 200);
    }
}