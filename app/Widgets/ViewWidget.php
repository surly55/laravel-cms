<?php

namespace App\Widgets;

use App\Models\Field;
use App\Models\View;

class ViewWidget
{
    const ID = 'view';
    const NAME = 'View';

    public static function configure(array $data = null) 
    {
        $views = View::orderBy('name')->get();

        return [
            'requires' => [ 'widgets/view.min.js' ],
            'form' => view('widget.view.configure', [ 'data' => $data, 'views' => $views ])->render(),
        ];
    }

    public function transform(array $data)
    {
        $fieldTypes = $this->loadFields();
        $view = View::find($data['view']);
        $data['items'] = [];
        $data['display'] = $view->display;
        $pages = $view->buildQuery()->with('type')->get();
        foreach($pages as $page) {
            $pageArr = $page->toArray();
            foreach($page->type->fields as $id => $field) {
                $field = Field::find($field['field']);
                $fieldClass = $fieldTypes[$field->type]['class'];
                $field = new $fieldClass();
                if(method_exists($field, 'transform')) {
                    $pageArr['content'][$id] = $field->transform($page->content[$id]);
                }
            }
            $data['items'][] = $pageArr;
        }

        return $data;
    }

    private function loadFields()
    {
        $fieldTypes = [];
        $fieldFiles = glob(app_path() . '/Fields/*Field.php');

        foreach($fieldFiles as $ff) {
            $className = substr(basename($ff), 0, -4);
            $fqcn = '\App\Fields\\' . $className;
            $fieldTypes[$fqcn::ID] = [
                'name' => $fqcn::NAME,
                'class' => $fqcn,
            ];
        }

        return $fieldTypes;
    }
}