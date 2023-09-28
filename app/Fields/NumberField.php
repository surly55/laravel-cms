<?php

namespace App\Fields;

use App\Models\Field;

class NumberField 
{
    const ID = 'number';
    const NAME = 'Number';

    public function configure(array $data = null)
    {
        $configuration = [
            'html' => view('fields.number.configure', [ 'data' => $data ])->render(),
        ];

        return $configuration;
    }

    public function rules(array $config = null)
    {
        $rules = [ 'integer' ];
        if(isset($config['min'])) {
            $rules[] = 'min:' . $config['min'];
        }
        if(isset($config['max'])) {
            $rules[] = 'max:' . $config['max'];
        }

        return $rules;
    }

    public function set($value)
    {
        return (int)$value;
    }

    public static function filters()
    {
        $html = view('fields.number.filter', [
            'condition' => 'eq',
        ])->render();

        return [
            'filters' => [
                'gt' => 'Greater than',
                'gte' => 'Greater than or equal',
                'lt' => 'Lesser than',
                'lte' => 'Lesser than or equal',
            ],
            'html' => $html,
        ];
    }

    public static function filter($condition)
    {
        $html = view('fields.number.filter', [
            'condition' => $condition,
        ])->render();

        return [
            'html' => $html,
        ];
    }

    public static function render($id, array $field, $data = null) 
    {
        $_field = Field::find($field['field']);
        $defaultValue = isset($_field->configuration['default']) ? $_field->configuration['default'] : '';
        $value = $data !== null ? $data : $defaultValue;

        $html = view('fields.number.render', [
            'id' => $id,
            'field' => $field,
            'data' => $data,
            'value' => $value,
        ])->render();

        return [
            'id' => $id,
            'html' => $html
        ];
    }
}