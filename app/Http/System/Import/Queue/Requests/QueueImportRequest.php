<?php

namespace App\Http\System\Import\Queue\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QueueImportRequest extends FormRequest
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
            'imports' => 'required',
        ];
    }

    public function messages()
    {
        return [
                'name.required' => 'Ingrese el nombre de la secuencia',
                'imports.required' => 'seleccione almenos 2 modulos de importacion'
        ];
    }
}
