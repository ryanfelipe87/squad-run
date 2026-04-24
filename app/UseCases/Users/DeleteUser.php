<?php

namespace App\UseCases\Users;

use App\Contracts\UserRepositoryInterface;
use DomainException;

class DeleteUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ){}

    public function execute(int $id) : void
    {
        $user = $this->userRepository->findById($id);

        if(!$user){
            throw new DomainException('Usuário não encontrado.');
        }

        $this->userRepository->delete($user);
    }
}
