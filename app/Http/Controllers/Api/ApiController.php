<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\Request;

abstract class ApiController extends Controller
{
    protected $site;
    protected $locale;

    public function __construct(Request $request)
    {
        $siteId = null;
        if($request->header('X-Site') !== null) {
            $siteId = $request->header('X-Site');
        } else if($request->has('site')) {
            $siteId = $request->get('site');
        }
        if($siteId) {
            $this->site = Site::find($siteId);
        }

        if($request->header('X-Locale') !== null) {
            $this->locale = $request->header('X-Locale');
        } else if($request->has('locale')) {
            $this->locale  = $request->get('locale');
        }
    }
}