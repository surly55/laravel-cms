<?php

namespace App\Http\Controllers;

use App\Http\Requests\WidgetTypeRequest;
use App\Models\Site;
use App\Models\WidgetType;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class WidgetTypeController extends Controller
{
    /**
     * List widget types
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $widgetTypes = WidgetType::paginate(10);

        return view('widget-type.index', [
            'title' => 'Widget types',
            'widgetTypes' => $widgetTypes,
            'bodyClasses' => 'model-index widget-type-index',
        ]);
    }

    /**
     * Show details for a widget type with given ID
     * 
     * @param string $id Widget type ID
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $widgetType = WidgetType::findOrFail($id);

        return view('widget-type.show', [
            'title' => 'View widget type: ' . $widgetType->name,
            'widgetType' => $widgetType,
            'bodyClasses' => 'model-show widget-type-show',
        ]);
    }

    /**
     * Form for creating new widget types
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $sites = Site::lists('name', '_id')->all();
        array_unshift($sites, '-- Choose site');

        return view('widget-type.create', [
            'title' => 'Create widget type',
            'sites' => $sites,
            'bodyClasses' => 'model-create widget-type-create',
        ]);
    }

    /**
     * Create new WidgetType and store it
     * 
     * @param \App\Http\Requests\WidgetTypeRequest $request Request
     */
    public function store(WidgetTypeRequest $request)
    {
        WidgetType::create($request->all());

        return redirect()->route('widget-type.index');
    }

    /**
     * Edit existing WidgetType
     * 
     * @param string $id Widget type ID
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $widgetType = WidgetType::findOrFail($id);

        return view('widget-type.edit', [
            'widgetType' => $widgetType,
            'bodyClasses' => 'model-edit widget-type-edit',
        ]);
    }

    /**
     * Update Widget type with given ID
     * 
     * @param string $id Widget type ID
     * @param \App\Http\Request\WidgetTypeRequest $request Request with widget type data
     * @return \Illuminate\Http\RedirectResponse Redirect back to widget types index
     */
    public function update($id, WidgetTypeRequest $request)
    {
        $widgetType = WidgetType::findOrFail($id);
        $widgetType->update($request->all());
        
        return redirect()->route('widget-type.index');
    }

    /**
     * Delete WidgetType
     */
    public function destroy($id, Request $request) 
    {
        try {
            WidgetType::destroy($id);
            if($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Widget type successfully deleted.',
                ], 200);
            }
        } catch(ModelNotFoundException $e) {
            if($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete widget type.',
                ], 500);
            }
            return redirect()->route('widget-type.index');
        }

        return redirect()->route('widget-type.index');
    }
}