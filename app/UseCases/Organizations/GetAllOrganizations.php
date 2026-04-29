<?php

namespace App\UseCases\Organizations;

use App\Repositories\OrganizationRepository;

class GetAllOrganizations
{
    public function __construct(
        private OrganizationRepository $repository
    ) {}

    public function execute()
    {
        return $this->repository->getAll();
    }
}
