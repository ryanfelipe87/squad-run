<?php

namespace App\UseCases\Competitors;

use App\Repositories\CompetitorRepository;
use DomainException;

class GetCompetitorEvents {

    public function __construct(
        private CompetitorRepository $repository
    ) {}

    public function execute(int $userId)
    {
        $competitor = $this->repository->findByUserId($userId);

        if (!$competitor) {
            throw new DomainException('Competidor não encontrado para o usuário fornecido.');
        }

        return $this->repository->getEventsByUserId($userId);
    }
}
