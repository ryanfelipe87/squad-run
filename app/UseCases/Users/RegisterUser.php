<?php

namespace App\UseCases\Users;

use App\Contracts\UserRepositoryInterface;
use App\DTOs\RegisterUserDTO;
use App\Jobs\SendConfirmationEmailJob;
use App\Models\User;
use DomainException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ){}

    public function execute(RegisterUserDTO $dto) : User
    {
        if($this->userRepository->findByEmail($dto->email)){
            throw new DomainException('E-mail já cadastrado.');
        }

        $user = $this->userRepository->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
            'role' => $dto->role
        ]);

        event(new Registered($user));
        return $user;
    }
}
