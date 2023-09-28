<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Page;
use App\Models\PageTemplate;
use App\Models\PageType;
use App\Models\PageTypeWidget;
use App\Models\Site;
use App\Http\Requests\PageTypeRequest;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PageTypeController extends Controller 
{

    public function index(Request $request)
    {
        $viewData = [
            'title' => 'Page types',
            'bodyClasses' => 'model-index pagetype-index',
            'search' => [],
        ];

        $query = PageType::query();
        if($request->has('name')) {
            $query->where('name', 'regexp', '/.*' . $request->get('name') . '.*/i');
            $viewData['search']['name'] = $request->get('name');
        }

        $sortRule = 'name';
        $sortOrder = 'asc';
        if($request->has('sort')) {
            $sortRule = $request->get('sort');
        }
        if($request->has('order')) {
            $sortOrder = $request->get('order');
        }
        $viewData['sortRule'] = $sortRule;
        $viewData['sortOrder'] = $sortOrder;
        $query = $query->orderBy($sortRule, $sortOrder);

        if($request->ajax()) {
            $pageTypes = $query->get();
            return response()->json($pageTypes);
        }
        
        $pageTypes = $query->paginate(20);
        $viewData['pageTypes'] = $pageTypes;

        return view('page-type.index', $viewData);
    }

    public function show($id, Request $request) 
    {
        $pageType = PageType::with('attachedWidgets.widget', 'templates')->findOrFail($id);
        //return response()->json($pageType->attachedWidgets[0]->widget);
        if($request->ajax()) {
            return response()->json($pageType->toArray());
        }

        return view('page-type.show', [ 
            'title' => 'View page type: ' . $pageType->name,
            'pageType' => $pageType,
            'bodyClasses' => 'model-show pagetype-show'
        ]);
    }

    public function create()
    {
        $fields = Field::orderBy('name')->get()->pluck('name', '_id');
        $sites = Site::with('locales')->orderBy('name')->get([ '_id', 'name' ])->keyBy('_id');
        $pageTemplates = PageTemplate::get()->keyBy('_id');

        return view('page-type.create', [
            'title' => 'Create new page type',
            'fields' => $fields,
            'sites' => $sites,
            'pageTemplates' => $pageTemplates,
            'bodyClasses' => 'model-create pagetype-create',
        ]);
    }

    public function store(PageTypeRequest $request)
    {
        $pageType = PageType::create($request->except('templates'));
        if(!$request->has('templates')) {
            $defaultPageTemplate = new PageTemplate([
                'name' => $pageType->name . ' (default)',
                'template_id' => 'default',
                'description' => 'Auto-generated default page template for ' . $pageType->name . ' page type.',
                'regions' => [ [ 'name' => 'Default', 'id' => 'default' ] ],
            ]);
            $pageType->templates()->save($defaultPageTemplate);
        }

        return redirect()->route('page-type.index');
    }

    public function edit($id)
    {
        $pageType = PageType::with([ 'locales', 'templates' ])->findOrFail($id);
        $fields = Field::orderBy('name')->get()->pluck('name', '_id');
        $sites = Site::with('locales')->orderBy('name')->get([ '_id', 'name' ])->keyBy('_id');
        $pageTemplates = PageTemplate::get()->keyBy('_id');

        return view('page-type.edit', [
            'title' => 'Edit page type: ' . $pageType->name,
            'pageType' => $pageType,
            'fields' => $fields,
            'sites' => $sites,
            'pageTemplates' => $pageTemplates,
            'bodyClasses' => 'model-edit pagetype-edit',
        ]);
    }

    public function update($id, PageTypeRequest $request)
    {
        $pageType = PageType::findOrFail($id);
        $pageType->fill($request->all());

        $pageType->locales()->sync($request->get('locales'));
        $pageType->templates()->sync($request->get('templates'));

        $pageType->attachedWidgets()->delete();
        if($request->has('widgets')) {
            $widgets = $request->get('widgets');
            foreach($widgets['widget'] as $i => $widget) {
                $widget = new PageTypeWidget([
                    'widget_id' => $widget,
                    'site_locale_id' => $widgets['locale'][$i],
                    'template_id' => $widgets['template'][$i],
                    'region' => $widgets['region'][$i],
                    'weight' => $widgets['weight'][$i],
                ]);
                $pageType->attachedWidgets()->associate($widget);
            }
        }
        $pageType->save();

        return redirect()->route('page-type.index');
    }

    public function destroy($id, Request $request) 
    {
        try {
            PageType::destroy($id);
            if($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Page type successfully deleted.',
                ], 200);
            }
        } catch(ModelNotFoundException $e) {
            if($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete page type.',
                ], 500);
            }
            return redirect()->route('page-type.index');
        }

        return redirect()->route('page-type.index');
    }

    public function render($id, $page = null)
    {
        $pageType = PageType::findOrFail($id);
        $data = [];
        if(isset($page)) {
            $page = Page::findOrFail($page);
            $data = $page->content;
        }
        $fields = $this->loadFields();

        if(count($pageType->fields) == 0) {
            return response()->json([ 
                'error' => true, 
                'message' => 'This page type has no fields. You may add some by <a href="' . route('page-type.edit', [ 'id' => $pageType->id ]) . '">editing it</a>.'
            ]);
        }

        $response = [ 'fields' => [] ];
        foreach($pageType->fields as $id => $fieldData) {
            $field = Field::findOrFail($fieldData['field']);
            $fieldClass = $fields[$field->type]['class'];
            $fieldClass = new $fieldClass;
            $response['fields'][] = $fieldClass->render($id, $fieldData, isset($data[$id]) ? $data[$id] : null);
        }

        return response()->json($response);
    }

    public function templates($id)
    {
        $pageType = PageType::with('templates')->findOrFail($id);
        $templates = [];
        foreach($pageType->templates as $tmpl) {
            $templates[] = [
                'id' => $tmpl->_id,
                'name' => $tmpl->name,
                'regions' => $tmpl->regions,
            ];
        }

        return response()->json($templates);
    }

    private function loadFields()
    {
        $fieldFiles = glob(app_path() . '/Fields/*Field.php');

        $fields = [];
        foreach($fieldFiles as $ff) {
            $className = substr(basename($ff), 0, -4);
            $fqcn = '\App\Fields\\' . $className;
            $fields[$fqcn::ID] = [
                'name' => $fqcn::NAME,
                'class' => $fqcn,
            ];
        }

        return $fields;
    }

}