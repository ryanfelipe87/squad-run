<?php

namespace App\UseCases\Auth;

use App\Contracts\UserRepositoryInterface;
use App\DTOs\LoginDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginUser
{
    public function __construct(
        private UserRepositoryInterface $repository
    ){}

    public function execute(LoginDTO $dto) : array
    {
        if(!Auth::attempt([
            'email' => $dto->email,
            'password' => $dto->password
        ])){
            throw ValidationException::withMessages([
                'email' => ['E-mail ou senha inválidos.']
            ]);
        }

        $user = Auth::user();

        $user->tokens()->delete();

        $expiresAt = now()->addMinutes(config('auth.token_expiration', 25));

        $token = $user->createToken('auth_token', ['*'], $expiresAt)->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
            'expires_at' => $expiresAt->toDateTimeString()
        ];
    }
}
