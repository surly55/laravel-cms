<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PageTypeRequest extends Request
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
            'name' => 'required|max:32',
            'uri' => 'required',
            'site_id' => 'required',
            'locales' => 'required',
        ];
        
        if($this->page_type) {
            $rules['templates'] = 'required';
        }

        return $rules;
    }
}
