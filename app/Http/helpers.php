<?php

if(!function_exists('invertSortOrder')) {
    function invertSortOrder($order) {
        switch($order) {
            case 'asc':
                return 'desc';
            case 'desc':
            default:
                return 'asc';
        }
    }
}

if(!function_exists('input')) {
    function input($name, $type = 'text', $value = '', $label = null, array $attributes = [], array $errors = [])
    {
        if($label === null) {
            $label = ucwords($name);
        }

        $attributes['class'] = isset($attributes['class']) ? 'form-control ' . $attributes['class'] : 'form-control';

        $htmlAttributes = '';
        foreach($attributes as $n => $v) {
            $htmlAttributes .= ' ' . $n . '="' . e($v) . '"';
        }

        $output = '<div class="form-group">
        <label for="' . $name . '" class="col-sm-2 control-label">' . $label . '</label>
        <div class="col-sm-10">
        <input id="' . $name . '" name="' . $name . '" value="' . e($value) . '" ' . $htmlAttributes . '>
        </div>
        </div>';
        return $output;
    }
}

if(!function_exists('select')) {
    function select($name, array $options = [], $selected = null, $label = null, array $attributes = [], array $errors = [])
    {
        if($label === null) {
            $label = ucwords($name);
        }

        $attributes['class'] = isset($attributes['class']) ? 'form-control ' . $attributes['class'] : 'form-control';

        $htmlAttributes = '';
        foreach($attributes as $n => $v) {
            $htmlAttributes .= ' ' . $n . '="' . e($v) . '"';
        }

        $output = '<div class="form-group">
        <label for="' . $name . '" class="col-sm-2 control-label">' . $label . '</label>
        <div class="col-sm-10">
        <select id="' . $name . '" name="' . $name . '" ' . $htmlAttributes . '>';
        foreach($options as $v => $l) {
            $output .= '<option value="' . e($v) . '">' . e($l) . '</option>';
        }
        $output .= '</select>
        </div>
        </div>';

        return $output;
    }
}

if(!function_exists('textarea')) {
    function textarea($name, $value = '', $label = null, $rows = null, $cols = null, array $attributes = [], array $errors = [])
    {
        if($label === null) {
            $label = ucwords($name);
        }

        $attributes['class'] = isset($attributes['class']) ? 'form-control ' . $attributes['class'] : 'form-control';

        $htmlAttributes = '';
        foreach($attributes as $n => $v) {
            $htmlAttributes .= ' ' . $n . '="' . e($v) . '"';
        }

        $output = '<div class="form-group">
        <label for="' . $name . '" class="col-sm-2 control-label">' . $label . '</label>
        <div class="col-sm-10">
        <textarea id="' . $name . '" name="' . $name . '"';
        if($rows !== null) {
            $output .= ' rows="' . $rows . '"';
        }
        if($cols !== null) {
            $output .= ' cols="' . $cols . '"';
        }
        $output .= ' ' . $htmlAttributes . '>' . e($value) . '</textarea>
        </div>
        </div>';

        return $output;
    }
}