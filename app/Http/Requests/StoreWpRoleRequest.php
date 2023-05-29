<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWpRoleRequest extends FormRequest
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
            "name"=> "required|alpha|lowercase|unique:wp_roles,name"
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
            'name.unique' => 'Le rôle existe déjà!',
            'name.alpha' => 'le nom du rôle doit uniquement être composé de caractères alphabétiques!',
            'name.lowercase' => 'le nom du rôle doit être en minuscules uniquement!'
        ];
    }
}
