<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWpSiteRequest extends FormRequest
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
            "name"=> 'sometimes|required|string|unique:wp_sites,name,'.request()->wpSite->id,
            "domain"=> "sometimes|required|string"
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
            'name.required' => 'Site name is required!',
            'domain.required' => 'Site domain is required!',
            'name.unique' => 'Site already exist!'
        ];
    }
}
