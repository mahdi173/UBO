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
            'userName' => 'required|string|unique:wp_users,userName',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|string|unique:wp_users,email'
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
