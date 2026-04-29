<?php

namespace App\UseCases\Organizations;

use App\DTOs\UpdateOrganizationDTO;
use App\Repositories\OrganizationRepository;
use DomainException;

class UpdateOrganization {

    public function __construct(
        private OrganizationRepository $repository
    ) {}

    public function execute(int $id, UpdateOrganizationDTO $dto)
    {
        $org = $this->repository->findById($id);

        if (!$org) {
            throw new DomainException('Organização não encontrada.');
        }

        $data = array_filter((array) $dto, fn($v) => !is_null($v));

        return $this->repository->update($org, $data);
    }
}
