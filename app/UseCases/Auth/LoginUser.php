<?php

namespace App\UseCases\Auth;

use App\DTOs\LoginDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginUser
{
    public function execute(LoginDTO $dto) : void
    {
        if(!Auth::attempt([
            'email' => $dto->email,
            'password' => $dto->password
        ], $dto->remember
        )){
            throw ValidationException::withMessages([
                'email' => ['As credenciais fornecidas estão incorretas.']
            ]);
        }
    }
}
