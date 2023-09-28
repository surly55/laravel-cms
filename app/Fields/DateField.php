<?php

namespace App\Fields;

use App\Models\Field;

class DateField 
{
    const ID = 'date';
    const NAME = 'Date';

    protected $configDefaults = [
        'format' => '%m/%d/%Y',
    ];

    public function configure(array $config = null)
    {
        if($config !== null) {
            $config = array_merge($this->configDefaults, $config);
        } else {
            $config = $this->configDefaults;
        }

        $configuration = [
            'html' => view('fields.date.configure', [ 'config' => $config ])->render(),
        ];

        return $configuration;
    }

    public function render($id, array $field, $data = null) 
    {
        $_field = Field::find($field['field']);
        $config = $this->configDefaults;
        if(isset($_field->configuration) && is_array($_field->configuration)) {
            $config = array_merge($config, $_field->configuration);
        }

        $data = $data !== null ? strftime($config['format'], $data) : null;
        $html = view('fields.date.render', [
            'id' => $id,
            'field' => $field,
            'data' => $data,
            'config' => $config,
        ])->render();

        return [
            'id' => $id,
            'requires' => [ 'jqueryui.min.js', 'fields/date.min.js' ],
            'html' => $html,
            'style' => [ 'jquery-ui.min' ],
            'init' => 'date',
        ];
    }

    public static function filters()
    {
        $html = view('fields.date.filter', [
            'condition' => 'eq',
        ])->render();

        return [
            'filters' => [
                'before' => 'Before',
                'beforei' => 'Before (including)',
                'after' => 'After',
                'afteri' => 'After (including)',
                'between' => 'Between',
            ],
            'html' => $html,
        ];
    }

    public static function filter($condition)
    {
        $html = view('fields.date.filter', [
            'condition' => $condition,
        ])->render();

        return [
            'html' => $html,
        ];
    }

    public function set($value)
    {
        return strtotime($value);
    }
}