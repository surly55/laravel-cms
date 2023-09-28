<?php

namespace App\Http\Controllers;

use App\Models\TaxonomicGroup;
use App\Models\TaxonomicTerm;
use App\Http\Requests\TaxonomyRequest;
use Illuminate\Http\Request;

class TaxonomyController extends Controller 
{
    public function index(Request $request)
    {
        $viewData = [
            'title' => 'Taxonomy',
            'bodyClasses' => 'model-index taxonomy-index',
            'searchParameters' => [],
        ];

        $query = TaxonomicGroup::query();

        if($request->has('name')) {
            $query->where('name', '/.*' . $request->get('name') . '.*/i');
            $viewData['searchParameters']['name'] = $request->get('name');
        }

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

        $taxonomicGroups = $query->orderBy($sortRule, $sortOrder)->paginate(20);
        $viewData['taxonomicGroups'] = $taxonomicGroups;

        return view('taxonomy.index', $viewData);
    }

    public function show($id)
    {
        return 'Not yet implemented.';
    }

    public function create()
    {
        return view('taxonomy.create', [
            'Title' => 'Create new group',
            'bodyClasses' => 'model-create taxonomy-create',
        ]);
    }

    public function store(TaxonomyRequest $request)
    {
        $taxonomicGroup = new TaxonomicGroup($request->only('name'));
        if($request->has('terms')) {
            foreach($request->input('terms.name') as $i => $val) {
                $term = new TaxonomicTerm([
                    'name' => $val,
                    'key' => $request->input('terms.key.' . $i),
                ]);
                $taxonomicGroup->terms()->associate($term);
            }
        }
        $taxonomicGroup->save();

        return redirect()->route('taxonomy.index');
    }

    public function edit($id)
    {
        return 'Not yet implemented.';
    }

    public function update($id, TaxonomyRequest $request)
    {
        return 'Not yet implemented.';
    }

    public function destroy($id, Request $request)
    {
        return 'Not yet implemented.';
    }
}