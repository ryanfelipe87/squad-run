<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginService {

    public function login(array $data) : array {
        if(!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            throw ValidationException::withMessages([
                'email' => ['E-mail or password are incorrect.']
            ]);
        }

        $user = Auth::user();

        $user->tokens()->delete();

        $expiresAt = now()->addMinutes(25);

        $token = $user->createToken('auth_token', ['*'], $expiresAt)->plainTextToken;

        return [
            'message' => 'User logged in successfully.',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => $expiresAt->toDateTimeString(),
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]
        ];
    }
}
