<?php

namespace App\Http\WaterManagement\Historical\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoricalTypeRequest extends FormRequest
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
            'internal_id' => 'required|unique:historical_types,internal_id',
            'name' => 'required'
        ];
    }
}
