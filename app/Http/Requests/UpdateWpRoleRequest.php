<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWpRoleRequest extends FormRequest
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
            "name"=> 'sometimes|required|string|unique:wp_roles,name,'.request()->wpRole->id
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
            'name.required' => 'Le nom du rôle est requis!',
            'name.unique' => 'Le rôle existe déjà!'
        ];
    }
}
