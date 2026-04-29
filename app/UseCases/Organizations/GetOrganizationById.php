<?php

namespace App\UseCases\Organizations;

use App\Repositories\OrganizationRepository;
use DomainException;

class GetOrganizationById
{
    public function __construct(
        private OrganizationRepository $repository
    ) {}

    public function execute(int $id)
    {
        $org = $this->repository->findById($id);

        if (!$org) {
            throw new DomainException('Organização não encontrada.');
        }

        return $org;
    }
}
