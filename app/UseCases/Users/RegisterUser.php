<?php

namespace App\UseCases\Users;

use App\Contracts\UserRepositoryInterface;
use App\DTOs\RegisterUserDTO;
use App\Models\User;
use DomainException;

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

        return $this->userRepository->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password,
            'role' => $dto->role
        ]);
    }
}
