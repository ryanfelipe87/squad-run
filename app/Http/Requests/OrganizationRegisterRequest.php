<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'cnpj' => 'required|string|max:14|unique:organizations,cnpj',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:8',
            'description' => 'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'cnpj.required' => 'The CNPJ field is required.',
            'cnpj.max' => 'The CNPJ may not be greater than 14 characters.',
            'cnpj.unique' => 'The CNPJ has already been taken.',
            'city.required' => 'The city field is required.',
            'state.required' => 'The state field is required.',
            'zip_code.required' => 'The zip code field is required.',
            'zip_code.max' => 'The zip code may not be greater than 8 characters.',
        ];
    }
}
