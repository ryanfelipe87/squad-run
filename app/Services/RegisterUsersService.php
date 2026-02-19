<?php

namespace App\Services;

use App\Models\User;
use DomainException;
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

    public function getAllUsers() : array {
        $users = User::orderBy('id')->get();

        return [
            'message' => 'Users retrieved successfully.',
            'users' => $users
        ];
    }

    public function getUserById(int $id) : array {
        $user = User::find($id);

        $user ? $message = 'User retrieved successfully.' : $message = 'User not found.';

        return [
            'message' => $message,
            'user' => $user
        ];
    }

    public function updateUserById(int $id, array $data) : array {
        $user = User::find($id);

        if(!$user)
            throw new DomainException('User not found with id: ' . $id);

        $user->update($data);

        return [
            'message' => 'User updated successfully.',
            'user' => $user
        ];
    }

    public function deleteUserById(int $id) : array {
        $user = User::find($id);

        if(!$user)
            throw new DomainException('User not found with id: ' . $id);

        $user->delete();

        return [
            'message' => 'User deleted successfully.'
        ];
    }
}
