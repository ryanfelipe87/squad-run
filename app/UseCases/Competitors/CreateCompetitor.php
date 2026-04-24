<?php

namespace App\UseCases\Competitors;

use App\DTOs\CompetitorDTO;
use App\Repositories\CompetitorRepository;
use DomainException;

class CreateCompetitor {

    public function __construct(
        private CompetitorRepository $repository
    ) {}

    public function execute(CompetitorDTO $dto)
    {
        if ($this->repository->findByUserId($dto->userId)) {
            throw new DomainException('Usuário já é um competidor.');
        }

        return $this->repository->create([
            'id_user' => $dto->userId,
            'cpf' => $dto->cpf,
            'sexo' => $dto->sexo,
            'birth_date' => $dto->birth_date,
            'height' => $dto->height,
            'weight' => $dto->weight
        ]);
    }
}
