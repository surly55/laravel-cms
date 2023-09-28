<?php

namespace App\Http\Controllers;

use App\Http\Requests\FieldRequest;
use App\Models\Field;

use Illuminate\Http\Request;

class FieldController extends Controller
{
    private $fieldTypes = [];

    public function __construct()
    {
        $this->loadFields();
    }

    public function index(Request $request)
    {
        $viewData = [
            'title' => 'Fields',
            'fieldTypes' => $this->fieldTypes,
            'bodyClasses' => 'model-index field-index',
            'search' => [],
        ];

        $query = Field::query();
        if($request->has('name')) {
            $query->where('name', 'regexp', '/.*' . $request->get('name') . '.*/i');
            $viewData['search']['name'] = $request->get('name');
        }
        if($request->has('type')) {
            $query->where('type', $request->get('type'));
            $viewData['search']['type'] = $request->get('type');
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

        $fields = $query->orderBy($sortRule, $sortOrder)->paginate(20);
        $viewData['fields'] = $fields;

        return view('field.index', $viewData);
    }

    public function show($id)
    {
        $field = Field::findOrFail($id);

        return view('field.show', [
            'title' => 'Field: ' . $field->name,
            'field' => $field,
            'fieldTypes' => $this->fieldTypes,
            'bodyClasses' => 'model-show field-show',
        ]);
    }

    public function create()
    {
        return view('field.create', [
            'title' => 'Create new field',
            'fieldTypes' => $this->fieldTypes,
            'bodyClasses' => 'model-create field-create',
        ]);
    }

    public function store(FieldRequest $request)
    {
        Field::create($request->all());

        return redirect()->route('field.index');
    }

    public function edit($id)
    {
        $field = Field::findOrFail($id);
        $fieldConfiguration = $this->loadConfiguration($field->type, $field->configuration);

        return view('field.edit', [
            'title' => 'Edit field: ' . $field->name,
            'field' => $field,
            'fieldTypes' => $this->fieldTypes,
            'fieldConfiguration' => $fieldConfiguration,
            'bodyClasses' => 'model-edit field-edit',
        ]);
    }

    public function update($id, FieldRequest $request)
    {
        $field = Field::findOrFail($id);
        $field->update($request->all());

        return redirect()->route('field.index');
    }

    public function destroy($id, Request $request)
    {
        try {
            Field::destroy($id);
            if($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Field successfully deleted.',
                ], 200);
            }
        } catch(ModelNotFoundException $e) {
            if($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete field.',
                ], 500);
            }
            return redirect()->route('field.index');
        }

        return redirect()->route('field.index');
    }

    public function configure($type = null, $data = null)
    {
        $configuration = [
            'configurable' => false,
        ];

        if(($fieldConfiguration = $this->loadConfiguration($type, $data)) !== null) {
            $configuration['configurable'] = true;
            $configuration = array_merge($configuration, $fieldConfiguration);
        }

        return response()->json($configuration);
    }

    public function filters($id)
    {
        $field = Field::findOrFail($id);
        $fieldClass = $this->fieldTypes[$field->type]['class'];
        $field = new $fieldClass();

        $response = [ 'filters' => [] ];
        if(method_exists($field, 'filters')) {
            $response = $field->filters();
        }

        return response()->json($response);
    }

    public function filter($id, $condition)
    {
        $field = Field::findOrFail($id);
        $fieldClass = $this->fieldTypes[$field->type]['class'];
        $field = new $fieldClass();

        if(method_exists($field, 'filter')) {
            $filter = $field->filter($condition);
            return response()->json($filter);
        }

        return response()->json();
    }

    private function loadConfiguration($type, $data = null)
    {
        $fieldClass = $this->fieldTypes[$type]['class'];
        $field = new $fieldClass();

        if(method_exists($field, 'configure')) {
            return $field->configure($data);
        }

        return null;
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
