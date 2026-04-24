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

        $accessExpiresAt = now()->addMinutes(15);
        $refreshExpiresAt = now()->addDays(7);

        $accessToken = $user->createToken('access_token', ['access'], $accessExpiresAt)->plainTextToken;

        $refreshToken = $user->createToken('refresh_token', ['refresh'], $refreshExpiresAt)->plainTextToken;

        return [
            'user' => $user,
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'expires_at' => $accessExpiresAt
        ];
    }
}
