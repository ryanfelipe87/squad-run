<?php

namespace App\UseCases\Competitors;

use App\DTOs\UpdateCompetitorDTO;
use App\Repositories\CompetitorRepository;
use DomainException;

class UpdateCompetitor {

    public function __construct(
        private CompetitorRepository $repository
    ) {}

    public function execute(int $id, UpdateCompetitorDTO $dto)
    {
        $competitor = $this->repository->findById($id);

        if (!$competitor) {
            throw new DomainException('Competidor não encontrado.');
        }

        $data = array_filter([
            'cpf' => $dto->cpf,
            'sexo' => $dto->sexo,
            'birth_date' => $dto->birth_date,
            'height' => $dto->height,
            'weight' => $dto->weight
        ], fn($value) => !is_null($value));

        return $this->repository->update($competitor, $data);
    }
}
