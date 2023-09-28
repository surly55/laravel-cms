<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Api\Exception as ApiException;
use App\Exceptions\Api\NotFoundException;
use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\Page;
use App\Models\Widget;

use Illuminate\Http\Request;

class PageController extends ApiController
{
    private $fieldTypes = [];

    public function __construct() 
    {
        $this->loadFields();
    }

    public function index(Request $request) 
    {
        $widgetClasses = $this->loadWidgets();
        
        $pagesQuery = Page::query();
        if($request->has('site')) {
            $pagesQuery->where('site_id', $request->get('site'));
        } else {
            throw new ApiException('Parameter site is missing');
        }
        if($request->has('locale')) {
            $pagesQuery->where('site_locale_id', $request->get('locale'));
        }
        if($request->has('url')) {
            $pagesQuery->where('url', $request->get('url'));
        } else {
            throw new ApiException('Parameter url is missing');
        }

        $page = $pagesQuery->with('type', 'template', 'metadata')->first();
        if($page === null) {
            throw new NotFoundException('Page not found');
        }
        $pageArr = $page->toArray();

        // Parent hierarchy
        $pageArr['parents'] = null;
        if($page->parent) {
            $parent = $page->parent;
            $pageArr['parents'][] = [
                'title' => $parent->title,
                'url' => $parent->url
            ];
            while($parent->parent) {
                $parent = $parent->parent;
                $pageArr['parents'][] = [
                    'title' => $parent->title,
                    'url' => $parent->url
                ];
            }
        }

        // Field transformations
        foreach($page->type->fields as $id => $field) {
            $field = Field::find($field['field']);
            $fieldClass = $this->fieldTypes[$field->type]['class'];
            $field = new $fieldClass();
            if(method_exists($field, 'transform')) {
                $pageArr['content'][$id] = $field->transform($pageArr['content'][$id]);
            }
        }
        
        if(isset($pageArr['widgets'])) {
            $widgets = [];
            foreach($pageArr['widgets'] as $w) {
                $widget = Widget::find($w['id']);
                if($widget) {
                    $widget = $widget->toArray();
                    $widget['group'] = $w['group'];
                    $widget['weight'] = (int)$w['weight'];
                    $widgetClass = new $widgetClasses[$widget['type']]['class'];
                    if(method_exists($widgetClass, 'transform')) {
                        $widget['data'] = $widgetClass->transform($widget['data']);
                    }
                    if(isset($w['config'])) {
                        $widget['config'] = $w['config'];
                    }
                    $widgets[] = $widget;
                }
            }
            $pageArr['widgets'] = $widgets;
        }

        return response()->json($pageArr);
    }

    public function show($id)
    {
        $widgetClasses = $this->loadWidgets();
        
        $page = Page::find($id);
        if($page === null) {
            throw new NotFoundException('Page not found');
        }
        $pageArr = $page->toArray();

        // Field transformations
        foreach($page->type->fields as $id => $field) {
            $field = Field::find($field['field']);
            $fieldClass = $this->fieldTypes[$field->type]['class'];
            $field = new $fieldClass();
            if(method_exists($field, 'transform')) {
                $pageArr['content'][$id] = $field->transform($pageArr['content'][$id]);
            }
        }
        
        if(isset($pageArr['widgets'])) {
            $widgets = [];
            foreach($pageArr['widgets'] as $w) {
                $widget = Widget::find($w['id']);
                if($widget) {
                    $widget = $widget->toArray();
                    $widget['group'] = $w['group'];
                    $widget['weight'] = (int)$w['weight'];
                    $widgetClass = new $widgetClasses[$widget['type']]['class'];
                    if(method_exists($widgetClass, 'transform')) {
                        $widget['data'] = $widgetClass->transform($widget['data']);
                    }
                    if(isset($w['config'])) {
                        $widget['config'] = $w['config'];
                    }
                    $widgets[] = $widget;
                }
            }
            $pageArr['widgets'] = $widgets;
        }

        return response()->json($pageArr);
    }

    public function search(Request $request)
    {
        $widgetClasses = $this->loadWidgets();
        
        $pagesQuery = Page::query();
        if($this->site) {
            $pagesQuery->where('site_id', $this->site->id);
        }
        if($request->has('q')) {
            $pagesQuery->where('title', 'regexp', '/.*' . urldecode($request->get('q')) . '.*/i')
                ->whereOr('content.content', 'regexp', '/.*' . urldecode($request->get('q')) . '.*/i');
        }

        $pages = $pagesQuery->with('type', 'template')->get();
        if(count($pages) === 0) {
            throw new NotFoundException('Page not found');
        }
        $pagesArr = [];

        // Field transformations
        foreach($pages as $page) {
            $pagesArr[] = [
                'title' => $page->title,
                'url' => $page->url,
                'content' => isset($page->content['content']) ? $page->content['content'] : '',
            ];
        }

        return response()->json($pagesArr);
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

    private function loadFields()
    {
        $fieldFiles = glob(app_path() . '/Fields/*Field.php');

        foreach($fieldFiles as $ff) {
            $className = substr(basename($ff), 0, -4);
            $fqcn = '\App\Fields\\' . $className;
            $this->fieldTypes[$fqcn::ID] = [
                'name' => $fqcn::NAME,
                'class' => $fqcn,
            ];
        }
    }
}