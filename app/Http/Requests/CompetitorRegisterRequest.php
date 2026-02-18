<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompetitorRegisterRequest extends FormRequest
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
            'cpf' => ['required', 'string', 'max:11', 'unique:competitors,cpf'],
            'birth_date' => ['required', 'date'],
            'sexo' => ['required','string','max:15'],
            'height' => ['required','numeric'],
            'weight' => ['required','numeric']
        ];
    }
}
