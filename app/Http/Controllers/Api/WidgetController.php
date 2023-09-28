<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Api\NotFoundException;
use App\Models\Widget;

class WidgetController extends ApiController
{
    public function show($id) 
    {
        $widget = Widget::where('widget_id', $id);
        if($this->site) {
            $widget->where('site_id', $this->site->_id);
        }
        if($this->locale) {
            $widget->where('locale', $this->locale);
        }
        $widget = $widget->first();
        
        if($widget === null) {
            throw new NotFoundException('Widget not found');
        }

        $widgetArr = $widget->toArray();
        
        $widgetClasses = $this->loadWidgets();
        $widgetClass = new $widgetClasses[$widget['type']]['class'];
        if(method_exists($widgetClass, 'transform')) {
            $widgetArr['data'] = $widgetClass->transform($widgetArr['data']);
        }

        return response()->json($widgetArr);
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