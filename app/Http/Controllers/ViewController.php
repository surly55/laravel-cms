<?php

namespace App\Http\Controllers;

use App\Models\View;
use App\Models\ViewCriteria;
use App\Models\ViewSortRule;
use App\Models\Site;

use Illuminate\Http\Request;

class ViewController extends Controller 
{
    public function index(Request $request)
    {
        $viewData = [
            'title' => 'Pagelists',
            'bodyClasses' => 'model-index view-index',
        ];

        $query = View::query();
        $sortRule = 'updated_at';
        $sortOrder = 'desc';
        if($request->has('sort')) {
            $sortRule = $request->get('sort');
        }
        if($request->has('order')) {
            $sortOrder = $request->get('order');
        }
        $viewData['sortRule'] = $sortRule;
        $viewData['sortOrder'] = $sortOrder;
        $query->orderBy($sortRule, $sortOrder);

        $views = $query->paginate(20);
        $viewData['views'] = $views;

        return view('view.index', $viewData);
    }

    public function create()
    {
        $rules = [
            'site' => 'Site',
            'locale' => 'Locale',
            'page-type' => 'Page type',
            'published' => 'Published'
        ];

        $conditions = [
            '_basic' => [
                'eq' => 'Is (Equals)',
                'neq' => 'Is Not (Not equal)',
            ],
        ];

        $sortRules = [
            'created' => 'Created',
            'updated' => 'Updated',
        ];

        return view('view.create', [
            'title' => 'Create new view',
            'rules' => $rules,
            'conditions' => $conditions,
            'sortRules' => $sortRules,
            'action' => 'create',
            'bodyClasses' => 'model-create view-create',
        ]);
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $view = new View($request->except('criteria', 'sort'));
        foreach($request->input('criteria.rule') as $i => $val) {
            $criteria = new ViewCriteria([
                'rule' => $val,
                'condition' => $request->input('criteria.condition.' . $i),
                'value' => $request->input('criteria.value.' . $i),
            ]);
            $view->criterias()->associate($criteria);
        }
        foreach($request->input('sort.rule') as $i => $val) {
            $sortRule = new ViewSortRule([
                'rule' => $val,
                'order' => $request->input('sort.order.' . $i),
            ]);
            $view->sortRules()->associate($sortRule);
        }
        $view->save();

        return redirect()->route('view.index');
    }

    public function edit($id)
    {
        $view = View::findOrFail($id);

        $rules = [
            'site' => 'Site',
            'locale' => 'Locale',
            'page-type' => 'Page type',
            'published' => 'Published'
        ];

        $conditions = [
            '_basic' => [
                'eq' => 'Is (Equals)',
                'neq' => 'Is Not (Not equal)',
            ],
        ];

        $sortRules = [
            'created' => 'Created',
            'updated' => 'Updated',
        ];

        return view('view.edit', [
            'title' => 'Edit view: ' . $view->name,
            'view' => $view,
            'rules' => $rules,
            'conditions' => $conditions,
            'sortRules' => $sortRules,
            'action' => 'edit',
            'bodyClasses' => 'model-edit view-edit',
        ]);
    }

    public function duplicate($id)
    {
        $view = View::findOrFail($id);

        $rules = [
            'site' => 'Site',
            'locale' => 'Locale',
            'page-type' => 'Page type',
            'published' => 'Published'
        ];

        $conditions = [
            '_basic' => [
                'eq' => 'Is (Equals)',
                'neq' => 'Is Not (Not equal)',
            ],
        ];

        $sortRules = [
            'created' => 'Created',
            'updated' => 'Updated',
        ];

        return view('view.create', [
            'title' => 'Duplicate view: ' . $view->name,
            'view' => $view,
            'rules' => $rules,
            'conditions' => $conditions,
            'sortRules' => $sortRules,
            'action' => 'duplicate',
            'bodyClasses' => 'model-edit view-edit',
        ]);
    }

    public function update($id, Request $request)
    {
        $view = View::findOrFail($id);
        $view->fill($request->except('criteria', 'sort'));

        $view->criterias()->delete();
        foreach($request->input('criteria.rule') as $i => $val) {
            $criteria = new ViewCriteria([
                'rule' => $val,
                'condition' => $request->input('criteria.condition.' . $i),
                'value' => $request->input('criteria.value.' . $i),
            ]);
            $view->criterias()->associate($criteria);
        }

        $view->sortRules()->delete();
        foreach($request->input('sort.rule') as $i => $val) {
            $sortRule = new ViewSortRule([
                'rule' => $val,
                'order' => $request->input('sort.order.' . $i),
            ]);
            $view->sortRules()->associate($sortRule);
        }

        $view->save();

        return redirect()->route('view.index');
    }

    public function destroy($id, Request $request) 
    {
        try {
            View::destroy($id);
            if($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'View successfully deleted.',
                ], 200);
            }
        } catch(ModelNotFoundException $e) {
            if($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete view.',
                ], 500);
            }
            return redirect()->route('view.index');
        }

        return redirect()->route('view.index');
    }
}