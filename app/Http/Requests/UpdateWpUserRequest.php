<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWpUserRequest extends FormRequest
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
            'userName' => 'sometimes|required|string|unique:wp_users,userName,'.request()->wpUser->id,
            'firstName' => 'sometimes|required|string',
            'lastName' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:wp_users,email,'.request()->wpUser->id,
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
            'userName.required' => 'UserName est requis!',
            'firstName.required' => 'Le prénom est requis!',
            'lastName.required' => 'Le nom est requis!',
            'email.required' => "L'email est requis!",
            'userName.unique' => 'UserName existe déjà!',
            'email.unique' => "L'email existe déjà!",
            'email.email'=> "L'email n'est pas valide"
        ];
    }
}
