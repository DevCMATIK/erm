<?php

namespace App\Http\Inspection\CheckList\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckListRequest extends FormRequest
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
        return [
            'check_point_type_id' => 'required',
            'name' => 'required'
        ];
    }
}
