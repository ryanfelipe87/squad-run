<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterUsersService {

    public function register(array $data) : array {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role']
        ]);

        return [
            'message' => 'User registered successfully.',
            'user' => $user
        ];
    }
}
