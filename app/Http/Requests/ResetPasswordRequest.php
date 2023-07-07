<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'password' => 'required|string|min:6|same:password_confirmation',
            'password_confirmation' => 'required|string'
        ];
    }


    /**
     * messages
     *
     * @return void
     */
    public function messages()
    {
        return [
            'password.required' => "Le mot de passe est requis!",
            'password_confirmation.required' => "Le deuxième champ du mot de passe est requis!",
            'password.same'=> "Les deux champs du mot de passe doivent être identiques!"
        ];
    }
}
