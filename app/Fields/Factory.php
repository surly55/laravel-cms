<?php

namespace App\Fields;

class Factory
{
    private $fields = [];

    public function __construct() 
    {
        $fieldFiles = glob(app_path() . '/Fields/*Field.php');

        foreach($fieldFiles as $ff) {
            $className = substr(basename($ff), 0, -4);
            $fqcn = '\App\Fields\\' . $className;
            $this->fields[$fqcn::ID] = [
                'name' => $fqcn::NAME,
                'class' => $fqcn,
            ];
        }
    }

    public function make($id)
    {
        return new $this->fields[$id]['class'];
    }
}