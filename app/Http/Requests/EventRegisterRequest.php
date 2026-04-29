<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRegisterRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'event_date' => ['required', 'date'],
            'vacancies' => ['required', 'integer'],
            'route_km' => ['required', 'numeric'],
            'route_description' => ['required', 'string']
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título é obrigatório.',
            'description.required' => 'A descrição é obrigatória.',
            'event_date.required' => 'A data do evento é obrigatória.',
            'vacancies.required' => 'As vagas são obrigatórias.',
            'route_km.required' => 'O km da rota é obrigatório.',
            'route_description.required' => 'A descrição da rota é obrigatória.'
        ];
    }
}
