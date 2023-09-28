<?php

namespace App\Http\Controllers;

use App\Http\Requests\WidgetRequest;
use App\Models\Site;
use App\Models\Widget;
use App\Models\WidgetType;
use App\Models\Locale;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use MongoDB\BSON\Regex as MongoRegex;

class WidgetController extends Controller
{
    private $widgetTypes = [];

    public function __construct()
    {
        $this->loadWidgets();
    }

    /**
     * List widgets
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $viewData = [
            'title' => 'Widgets',
            'types' => $this->widgetTypes,
            'bodyClasses' => 'model-index widget-index',
            'search' => [],
        ];

        $query = Widget::with('locale');
        if($request->has('name')) {
            $query->where('name', 'regexp', '/.*' . $request->get('name') . '.*/i');
            $viewData['search']['name'] = $request->get('name');
        }
        if($request->has('type')) {
            $query->where('type', $request->get('type'));
            $viewData['search']['type'] = $request->get('type');
        }
        if($request->has('site')) {
            $query->where('site_id', $request->get('site'));
            $viewData['search']['site'] = $request->get('site');
        }
        if($request->has('locale')) {
            $query->where('site_locale_id', $request->get('locale'));
            $viewData['search']['locale'] = $request->get('locale');
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

        $widgets = $query->with('site')->orderBy($sortRule, $sortOrder)->paginate(20);
        $viewData['widgets'] = $widgets;

        $sites = Site::with('locales')->orderBy('name')->get([ '_id', 'name']);
        $viewData['sites'] = $sites;
        $viewData['locales'] = [];
        foreach($sites as $site) {
            foreach($site->locales as $locale) {
                $viewData['locales'][$locale->_id] = $locale->name . ' (' . $locale->locale->code . ')';
            }
        }
        asort($viewData['locales']);

        return view('widget.index', $viewData);
    }

    /**
     * Show details for Widget with given ID
     *
     * @param string $id Widget ID
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $widget = Widget::findOrFail($id);

        return view('widget.show', [
            'title' => 'View widget: ' . $widget->name,
            'widget' => $widget,
            'bodyClasses' => 'model-show widget-show',
        ]);
    }

    /**
     * Form for creating new widgets
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $locales = ["test1", "test2"];

        $locales = Locale::orderBy('name')->get([ '_id', 'name' , 'code' ])->keyBy('_id');

        //var_dump($locales);
        $sites = Site::with('locales')->orderBy('name')->get([ '_id', 'name' ])->keyBy('_id');
        return view('widget.create', [
            'title' => 'Create widget',
            'sites' => $sites,
            'types' => $this->widgetTypes,
            'action' => 'create',
            'locales' => $locales,
            'bodyClasses' => 'model-create widget-create',
        ]);
    }

    public function duplicate($id)
    {
        $widget = Widget::findOrFail($id);
        $sites = Site::with('locales')->orderBy('name')->get([ '_id', 'name' ])->keyBy('_id');

        $widgetClass = new $this->widgetTypes[$widget->type]['class'];
        if(method_exists($widgetClass, 'configure')) {
            $widgetForm = $widgetClass->configure($widget->data);
        } else {
            $widgetForm = [ 'form' => 'Nothing to configure.' ];
        }
        $widgetScripts = [];
        if(isset($widgetForm['scripts'])) {
            $widgetScripts = $widgetForm['scripts'];
        }

        return view('widget.create', [
            'title' => 'Edit widget: ' . $widget->name,
            'widget' => $widget,
            'widgetForm' => $widgetForm['form'],
            'scripts' => $widgetScripts,
            'sites' => $sites,
            'types' => $this->widgetTypes,
            'action' => 'duplicate',
            'bodyClasses' => 'model-edit widget-edit',
        ]);
    }

    /**
     * Create new Widget and store it
     *
     * @param \App\Http\Requests\WidgetType $request Request
     * @return \Illuminate\Http\RedirectResponse Redirect back to list of widgets if successful
     */
    public function store(WidgetRequest $request)
    {
        $widget = new Widget($request->except([ 'config', 'data', 'images' ]));
        $widgetClass = $this->widgetTypes[$widget->type]['class'];
        if(method_exists($widgetClass, 'saveData')) {
            $widget->data = (new $widgetClass)->saveData($request->get('data'));
        } else {
            $widget->data = $request->get('data');
        }

        if(method_exists($widgetClass, 'saveData')) {
            $widget->images = (new $widgetClass)->saveData($request->get('images'));
        } else {
            $widget->images = $request->get('images');
        }

        if(method_exists($widgetClass, 'saveConfig')) {
            $widget->config = (new $widgetClass)->saveConfig($request->get('config'));
        } else {
            $widget->config = $request->get('config');
        }
        $widget->save();

        return redirect()->route('widget.index');
    }

    /**
     * Edit existing widget
     *
     * @param string $id Widget ID
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $widget = Widget::with('locale')->findOrFail($id);
        $sites = Site::with('locales')->orderBy('name')->get([ '_id', 'name' ])->keyBy('_id');

        $widgetClass = new $this->widgetTypes[$widget->type]['class'];
        if(method_exists($widgetClass, 'configure')) {
            $widgetForm = $widgetClass->configure($widget->data);
        } else {
            $widgetForm = [ 'form' => 'Nothing to configure.' ];
        }
        $widgetScripts = [];
        if(isset($widgetForm['scripts'])) {
            $widgetScripts = $widgetForm['scripts'];
        }

        return view('widget.edit', [
            'title' => 'Edit widget: ' . $widget->name,
            'widget' => $widget,
            'widgetForm' => $widgetForm['form'],
            'scripts' => $widgetScripts,
            'sites' => $sites,
            'types' => $this->widgetTypes,
            'action' => 'edit',
            'bodyClasses' => 'model-edit widget-edit',
        ]);
    }

    /**
     * Store updated Widget
     *
     * @param string $id Widget ID
     * @param \App\Http\Requests\WidgetType $request Request
     * @return \Illuminate\Http\RedirectResponse Redirect back to list of widgets if successful
     */
    public function update($id, WidgetRequest $request)
    {
        $widget = Widget::findOrFail($id);

        $widget->fill($request->except([ 'config', 'data' ]));

        $widgetClass = $this->widgetTypes[$widget->type]['class'];
        if(method_exists($widgetClass, 'saveData')) {
            $widget->data = (new $widgetClass)->saveData($request->get('data'));
        } else {
            $widget->data = $request->get('data');
        }
        if(method_exists($widgetClass, 'saveConfig')) {
            $widget->config = (new $widgetClass)->saveConfig($request->get('config'));
        } else {
            $widget->config = $request->get('config');
        }
        $widget->save();


        return redirect()->route('widget.index');
    }

    /**
     * Delete Widget
     */
    public function destroy($id, Request $request)
    {
        try {
            Widget::destroy($id);
            if($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Widget successfully deleted.',
                ], 200);
            }
        } catch(ModelNotFoundException $e) {
            if($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete widget.',
                ], 500);
            }
            return redirect()->route('widget.index');
        }

        return redirect()->route('widget.index');
    }

    /**
     * Returns widget configuration
     *
     * @param string $id WidgetType ID
     */
    public function configure($id)
    {
        $data = null;
        $configWidget = [ 'form' => 'Nothing to configure' ];

        if(substr($id, 0, 5) == 'type:') {
            $widgetClass = $this->widgetTypes[substr($id, 5)]['class'];
        } else {
            $widget = Widget::findOrFail($id);
            $data = $widget->data;
            $widgetClass = $this->widgetTypes[$widget->type]['class'];
        }

        $widget = new $widgetClass();
        if(method_exists($widget, 'configure')) {
            $configWidget = $widget->configure($data);
        }

        return response()->json($configWidget);
    }

    public function lookup($query, Request $request)
    {
        $query = Widget::where('name', 'regex', new MongoRegex('.*' . $query .'.*', 'i'));
        if($request->has('site')) {
            $query->where('site_id', $request->get('site'));
        }
        if($request->has('locales')) {
            $locales = $request->get('locales');
            if(!empty($locales)) {
                $locales = explode(',', $locales);
                if(count($locales) == 1) {
                    $query->where('site_locale_id', $locales[0]);
                } else {
                    $query->whereIn('site_locale_id', $locales);
                }
            }
        }

        $widgets = $query->get([ '_id', 'name' ]);

        return response()->json($widgets->toArray());
    }

    private function loadWidgets()
    {
        $widgetFiles = glob(app_path() . '/Widgets/*Widget.php');

        foreach($widgetFiles as $wf) {
            $className = substr(basename($wf), 0, -4);
            $fqcn = '\App\Widgets\\' . $className;
            $this->widgetTypes[$fqcn::ID] = [
                'name' => $fqcn::NAME,
                'class' => $fqcn,
            ];
        }
    }
}
