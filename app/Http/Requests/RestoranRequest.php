<?php

namespace App\Http\Requests;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator; 
use Illuminate\Foundation\Http\FormRequest;

class RestoranRequest extends FormRequest
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
            'naziv' => 'required|unique:restorani,naziv|max:45'
        ];
    }

    public function messages()
    {
        return [
            'naziv.required' => 'Ime restorana je obavezano!',
            'naziv.unique'  => 'Ime restorana je već zauzeto!',
        ];
    }
    
}
