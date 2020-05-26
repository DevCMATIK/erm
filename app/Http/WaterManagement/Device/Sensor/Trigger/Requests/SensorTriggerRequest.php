<?php

namespace App\Http\WaterManagement\Device\Sensor\Trigger\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SensorTriggerRequest extends FormRequest
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
            'receptor_id' => 'required',
            'minutes' => 'required',
        ];
    }
}
