<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckEmailRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email'
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
            'email.required' => "L'email est requis!",
            'email.exists' => "L'email n'existe pas!",
            'email.email'=> "L'email n'est pas valide"
        ];
    }
}
