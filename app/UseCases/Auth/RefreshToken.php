<?php

namespace App\UseCases\Auth;

use App\DTOs\RefreshTokenDTO;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class RefreshToken
{
    public function execute(RefreshTokenDTO $dto): array
    {
        $token = PersonalAccessToken::findToken($dto->refresh_token);

        if (!$token || !$token->can('refresh')) {
            throw ValidationException::withMessages([
                'token' => ['Refresh token inválido']
            ]);
        }

        if ($token->expires_at && $token->expires_at->isPast()) {
            throw ValidationException::withMessages([
                'token' => ['Refresh token expirado']
            ]);
        }

        $user = $token->tokenable;

        $user->tokens()->where('name', 'access_token')->delete();

        $newAccessExpiresAt = now()->addMinutes(15);

        $newAccessToken = $user->createToken(
            'access_token',
            ['access'],
            $newAccessExpiresAt
        )->plainTextToken;

        return [
            'access_token' => $newAccessToken,
            'expires_at' => $newAccessExpiresAt
        ];
    }
}
