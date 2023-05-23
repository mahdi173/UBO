<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWpUserRequest extends FormRequest
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
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email|unique:wp_users,email'
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
            'firstName.required' => 'Le prénom est requis!',
            'lastName.required' => 'Le nom est requis!',
            'email.required' => "L'email est requis!",
            'userName.unique' => 'Username existe déjà!',
            'email.unique' => "L'email existe déjà!",
            'email.email'=> "L'email n'est pas valide"
        ];
    }
}
