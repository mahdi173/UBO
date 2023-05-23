<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
                'userName' => 'sometimes|required|string|unique:users,userName,'.request()->user->id,
                'firstName' => 'sometimes|required|string',
                'lastName' => 'sometimes|required|string',
                'email' => 'sometimes|required|email|unique:users,email,'.request()->user->id,
                'role_id'=> 'sometimes|required|exists:roles,id'
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
            'userName.required' => 'Username est requis!',
            'firstName.required' => 'Le prénom est requis!',
            'lastName.required' => 'Le nom est requis!',
            'email.required' => "L'email est requis!",
            'userName.unique' => 'Username existe déjà!',
            'email.unique' => "L'email existe déjà!",
            'role_id.exists'=> "Le rôle n'existe pas!",
            'email.email'=> "L'email n'est pas valide"
        ];
    }
}
