<?php

namespace App\UseCases\Competitors;

use App\Repositories\CompetitorRepository;
use DomainException;

class DeleteCompetitor
{
    public function __construct(
        private CompetitorRepository $repository
    ) {}

    public function execute(int $id): void
    {
        $competitor = $this->repository->findById($id);

        if (!$competitor) {
            throw new DomainException('Competidor não encontrado.');
        }

        $this->repository->delete($competitor);
    }
}
