<?php

namespace App\Http\WaterManagement\Report\Request;

use Illuminate\Foundation\Http\FormRequest;

class MailReportRequest extends FormRequest
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
            'name' => 'required',
            'frequency' => 'required'
        ];
    }
}
