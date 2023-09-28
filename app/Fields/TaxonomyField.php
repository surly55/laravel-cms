<?php

namespace App\Fields;

use App\Models\Field;
use App\Models\TaxonomicGroup;

class TaxonomyField 
{
    const ID = 'taxonomy';
    const NAME = 'Taxonomy';

    public function configure(array $data = null)
    {
        $taxonomicGroups = TaxonomicGroup::get();

        $configuration = [
            'html' => view('fields.taxonomy.configure', [ 
                'data' => $data,
                'taxonomicGroups' => $taxonomicGroups,
            ])->render(),
        ];

        return $configuration;
    }
    
    public static function render($id, array $field, $data = null) 
    {
        $_field = Field::find($field['field']);
        $taxonomicGroup = TaxonomicGroup::find($_field->configuration['taxonomy']);

        $html = view('fields.taxonomy.render', [
            'id' => $id,
            'field' => $field,
            'data' => $data,
            'taxonomicGroup' => $taxonomicGroup,
        ])->render();

        return [
            'id' => $id,
            'html' => $html
        ];
    }

}