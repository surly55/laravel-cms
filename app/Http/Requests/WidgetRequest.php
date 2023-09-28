<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class WidgetRequest extends Request
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
        $id = $this->widget ?: 'null';
        $locale = $this->get('locale');

        return [
            'name' => 'required|max:100',
            'widget_id' => 'unique:widgets,widget_id,' . $id . ',_id,locale,' . $locale,
            'site_id' => 'required',
            'type' => 'required',
        ];
    }
}