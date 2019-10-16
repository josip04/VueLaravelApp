<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegRequest extends FormRequest
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
            'email' => 'required|email|unique:users',
            'name' => 'required|string|max:50|unique:users',
            'password' => 'required'
        ];
    }


    public function messages()
    {
        return [
            'email.required' => 'Moramo znati tvoju email adresu!',
            'email.unique' => 'Email adresa već postoji!',
            'name.required' => 'Korisničko ime je obavezno!',
            'name.unique' => 'Korisničko ime je već zauzeto!',
            'password.required' => 'Lozinka je obavezna!'
        ];
    }
}
