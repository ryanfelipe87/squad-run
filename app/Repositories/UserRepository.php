<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function create(array $data) : User
    {
        return User::create($data);
    }

    public function findById(int $id) : ?User
    {
        return User::find($id);
    }

    public function findByEmail(string $email) : ?User
    {
        return User::where('email', $email)->first();
    }

    public function getAll()
    {
        return User::orderBy('id')->get();
    }

    public function update(User $user, array $data) : User
    {
        $user->update($data);
        return $user;
    }

    public function delete(User $user) : void
    {
        $user->delete();
    }
}
