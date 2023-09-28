<?php

namespace App\Fields;

use App\Models\Field;

class LongTextField 
{
    const ID = 'long-text';
    const NAME = 'Long Text';

    protected $configDefaults = [
        'rows' => 5,
    ];

    public function configure(array $config = null)
    {
        if($config !== null) {
            $config = array_merge($this->configDefaults, $config);
        } else {
            $config = $this->configDefaults;
        }

        $configuration = [
            'html' => view('fields.long-text.configure', [ 'config' => $config ])->render(),
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

        $html = view('fields.long-text.render', [
            'id' => $id,
            'field' => $field,
            'data' => $data,
            'config' => $config,
        ])->render();

        return [
            'id' => $id,
            'html' => $html
        ];
    }

}