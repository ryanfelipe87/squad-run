<?php

namespace App\Http\Requests;

use App\Enums\UsersRoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class RegisterValidateRequest extends FormRequest
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
            'name' => ['required', 'string', 'filled', 'max:255'],
            'email' => ['required', 'email', 'filled', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', new Enum(UsersRoleEnum::class)]
        ];
    }

    public function messages() : array {
        return [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O E-mail é obrigatório.',
            'email.email' => 'O E-mail deve ser um endereço de email válido.',
            'email.unique' => 'O E-mail já está em uso.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
            'role.required' => 'O papel é obrigatório.',
            'role.enum' => 'O papel deve ser "organizator" ou "participant".'
        ];
    }
}
