<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiKeyRequest;
use App\Models\ApiKey;

class SettingController extends Controller
{
    public function index() 
    {
        $apiKeys = ApiKey::all();

        return view('setting.index', [
            'apiKeys' => $apiKeys
        ]);
    }

    public function addApiKey(ApiKeyRequest $request) 
    {
        ApiKey::create($request->all());

        return response()->json([
            'success' => true,
            'api_key' => $request->all(),
        ]);

        /*$errorMessage = 'Adding new API key failed for unknown reason!';
        if(Input::has('key') && Input::has('secret')) {
            $apiKey = new ApiKey(array(
                'key' => Input::get('key'),
                'secret' => Input::get('secret'),
            ));
            if($apiKey->save()) {
                return Response::json(array(
                    'success' => true,
                    'api_key' => $apiKey->toArray(),
                ), 200);
            } else {
                $errorMessage = 'Saving new API key failed!';
            }
        } else {
            $errorMessage = 'Key and secret are required!';
        }

        return Response::json(array(
            'success' => false,
            'message' => $errorMessage,
        ), 400);*/
    }
}