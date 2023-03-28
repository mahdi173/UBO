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
            'email' => 'sometimes|required|string|unique:wp_users,email,'.request()->wpUser->id,
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
            'userName.required' => 'UserName is required!',
            'firstName.required' => 'FirstName is required!',
            'lastName.required' => 'LastName is required!',
            'email.required' => 'Email is required!',
            'userName.unique' => 'UserName already exist!',
            'email.unique' => 'Email already exist!'
        ];
    }
}
