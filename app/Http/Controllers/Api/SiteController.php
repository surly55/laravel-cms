<?php

namespace App\Http\Controllers\Api;

//use App\Exceptions\Api\Exception as ApiException;
use App\Exceptions\Api\NotFoundException;
use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\Widget;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function show($id) 
    {
        $widgetClasses = $this->loadWidgets();

        $site = Site::with('attachedWidgets', 'locales')->find($id);
        if($site === null) {
            throw new NotFoundException('Site not found');
        }

        $siteArr = $site->toArray();
        $siteArr['widgets'] = [];
        foreach($site->attachedWidgets as $widgetData) {
            $widget = $widgetData->widget->toArray();
            $widget['locale'] = $widgetData->locale;
            $widget['region'] = $widgetData['region'];
            $widget['weight'] = $widgetData['weight'];
            $widgetClass = new $widgetClasses[$widget['type']]['class'];
            if(method_exists($widgetClass, 'transform') && is_array($widget['data'])) {
                $widget['data'] = $widgetClass->transform($widget['data']);
            }
            $siteArr['widgets'][] = $widget;
        }
        unset($siteArr['attachedWidgets'], $siteArr['attached_widgets']);

        return response()->json($siteArr);
    }

    private function loadWidgets()
    {
        $widgets = [];
        $widgetFiles = glob(app_path() . '/Widgets/*Widget.php');

        foreach($widgetFiles as $wf) {
            $className = substr(basename($wf), 0, -4);
            $fqcn = '\App\Widgets\\' . $className;
            $widgets[$fqcn::ID] = [
                'name' => $fqcn::NAME,
                'class' => $fqcn,
            ];
        }

        return $widgets;
    }
}