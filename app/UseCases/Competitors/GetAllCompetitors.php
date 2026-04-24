<?php

namespace App\UseCases\Competitors;

use App\Repositories\CompetitorRepository;

class GetAllCompetitors
{
    public function __construct(
        private CompetitorRepository $repository
    ) {}

    public function execute()
    {
        return $this->repository->getAll();
    }
}
