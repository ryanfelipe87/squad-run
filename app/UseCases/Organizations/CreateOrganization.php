<?php

namespace App\UseCases\Organizations;

use App\DTOs\CreateOrganizationDTO;
use App\Repositories\OrganizationRepository;
use DomainException;

class CreateOrganization
{
    public function __construct(
        private OrganizationRepository $repository
    ) {}

    public function execute(CreateOrganizationDTO $dto)
    {
        $alreadyExists = $this->repository->findByUserId($dto->userId);

        if ($alreadyExists) {
            throw new DomainException('Usuário já possui uma organização cadastrada.');
        }

        return $this->repository->create([
            'id_user' => $dto->userId,
            'name' => $dto->name,
            'cnpj' => $dto->cnpj,
            'city' => $dto->city,
            'state' => $dto->state,
            'zip_code' => $dto->zip_code,
            'description' => $dto->description
        ]);
    }
}
