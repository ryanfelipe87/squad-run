<?php

namespace App\UseCases\Users;

use App\Contracts\UserRepositoryInterface;
use App\DTOs\UpdateUserDTO;
use DomainException;

class UpdateUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ){}

    public function execute(int $id, UpdateUserDTO $dto)
    {
        $user = $this->userRepository->findById($id);

        if(!$user){
            throw new DomainException('Usuário não encontrado.');
        }

        $data = array_filter([
            'name' =>$dto->name,
            'email' => $dto->email,
        ]);

        return $this->userRepository->update($user, $data);
    }
}
