<?php

namespace App\UseCases\Organizations;

use App\Repositories\OrganizationRepository;
use DomainException;

class DeleteOrganization {

    public function __construct(
        private OrganizationRepository $repository
    ) {}

    public function execute(int $id): void
    {
        $org = $this->repository->findById($id);

        if (!$org) {
            throw new DomainException('Organização não encontrada.');
        }

        if ($this->repository->hasEvents($id)) {
            throw new DomainException('Não é possível excluir uma organização com eventos.');
        }

        $this->repository->delete($org);
    }
}
