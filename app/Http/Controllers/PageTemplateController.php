<?php

namespace App\Http\Controllers;

use App\Models\PageTemplate;
use App\Http\Requests\PageTemplateRequest;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PageTemplateController extends Controller 
{

    public function index(Request $request)
    {
        $viewData = [
            'title' => 'Page templates', 
            'bodyClasses' => 'model-index pagetemplate-index',
            'search' => [],
        ];

        $query = PageTemplate::query();
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

        $pageTemplates = $query->orderBy($sortRule, $sortOrder)->paginate(20);
        $viewData['pageTemplates'] = $pageTemplates;

        return view('page-template.index', $viewData);
    }

    public function show($id) 
    {
        $pageTemplate = PageTemplate::findOrFail($id);

        return view('page-template.show', [ 
            'title' => 'View page template: ' . $pageTemplate->name,
            'pageTemplate' => $pageTemplate,
            'bodyClasses' => 'model-show pagetemplate-show'
        ]);
    }

    public function create()
    {
        return view('page-template.create', [
            'title' => 'Create new page template',
            'bodyClasses' => 'model-create pagetemplate-create',
        ]);
    }

    public function store(PageTemplateRequest $request)
    {
        $pageTemplate = new PageTemplate($request->except('regions'));
        if($request->has('regions')) {
            $regions = [];
            foreach($request->input('regions.name') as $i => $val) {
                $regions[] = [
                    'id' => $request->input('regions.id.' . $i),
                    'name' => $val,
                ];
            }
            $pageTemplate->regions = $regions;
        }
        $pageTemplate->save();

        return redirect()->route('page-template.index');
    }

    
    public function edit($id)
    {
        $pageTemplate = PageTemplate::findOrFail($id);

        return view('page-template.edit', [
            'title' => 'Edit page template: ' . $pageTemplate->name,
            'pageTemplate' => $pageTemplate,
            'bodyClasses' => 'model-edit pagetemplate-edit',
        ]);
    }

    public function update($id, PageTemplateRequest $request)
    {
        $pageTemplate = PageTemplate::findOrFail($id);
        $pageTemplate->update($request->except('regions'));
        if($request->has('regions')) {
            $regions = [];
            foreach($request->input('regions.name') as $i => $val) {
                $regions[] = [
                    'id' => $request->input('regions.id.' . $i),
                    'name' => $val,
                ];
            }
            $pageTemplate->regions = $regions;
        }
        $pageTemplate->save();

        return redirect()->route('page-template.index');
    }

    public function destroy($id, Request $request) 
    {
        try {
            PageTemplate::destroy($id);
            if($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Page template successfully deleted.',
                ], 200);
            }
        } catch(ModelNotFoundException $e) {
            if($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete page template.',
                ], 500);
            }
            return redirect()->route('page-template.index');
        }

        return redirect()->route('page-template.index');
    }

}