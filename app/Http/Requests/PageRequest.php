<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Field;
use App\Models\PageType;
use FieldFactory;

class PageRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => 'required|max:200',
            'url' => 'required|max:255',
            //'type_id' => 'required|exists:page_types,_id',
            'site_id' => 'required|exists:sites,_id',
        ];

        $pageType = PageType::find($this->get('type_id'));
        if($pageType !== null) {
            foreach($pageType->fields as $fieldId => $fieldData) {
                $rules['content.' . $fieldId] = [];
                if($fieldData['required'] == 1) {
                    $rules['content.' . $fieldId][] = 'required';
                }
                $field = Field::find($fieldData['field']);
                $fieldFactory = new FieldFactory();
                $fieldClass = $fieldFactory->make($field->type);
                if(method_exists($fieldClass, 'rules')) {
                    $rules['content.' . $fieldId] = array_merge($rules['content.' . $fieldId], $fieldClass->rules($field->configuration));
                }
            }
        }

        return $rules;
    }
}
