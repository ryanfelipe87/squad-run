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
            'title.required' => 'The title field is required.',
            'description.required' => 'The description field is required.',
            'event_date.required' => 'The event date field is required.',
            'vacancies.required' => 'The vacancies field is required.',
            'route_km.required' => 'The route km field is required.',
            'route_description.required' => 'The route description field is required.'
        ];
    }
}
