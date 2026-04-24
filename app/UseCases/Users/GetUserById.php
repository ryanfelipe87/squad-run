<?php

namespace App\UseCases\Users;

use App\Contracts\UserRepositoryInterface;
use DomainException;

class GetUserById
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ){}

    public function execute(int $id)
    {
        $user = $this->userRepository->findById($id);

        if(!$user){
            throw new DomainException('Usuário não encontrado.');
        }

        return $user;
    }
}
