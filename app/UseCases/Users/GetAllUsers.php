<?php

namespace App\UseCases\Users;

use App\Contracts\UserRepositoryInterface;

class GetAllUsers
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ){}

    public function execute()
    {
        return $this->userRepository->getAll();
    }
}
