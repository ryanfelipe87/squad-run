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
            'name.required' => 'O nome é obrigatório.',
            'cnpj.required' => 'O CNPJ é obrigatório.',
            'cnpj.max' => 'O CNPJ não pode ter mais de 14 caracteres.',
            'cnpj.unique' => 'O CNPJ já foi utilizado.',
            'city.required' => 'A cidade é obrigatória.',
            'state.required' => 'O estado é obrigatório.',
            'zip_code.required' => 'O código postal é obrigatório.',
            'zip_code.max' => 'O código postal não pode ter mais de 8 caracteres.',
        ];
    }
}
