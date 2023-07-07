<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWpSiteRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                Rule::unique('wp_sites', 'name')->where(function ($query) {
                    $query->whereNull('deleted_at');
                })
            ],
            "domain"=> "required|string"
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
            'name.required' => 'Le nom du site est requis!',
            'domain.required' => 'Le domain du site est requis!',
            'name.unique' => 'Le site existe déjà!'
        ];
    }
}
