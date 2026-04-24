<?php

namespace App\DTOs;

class CompetitorDTO {
    public function __construct(
        public int $userId,
        public string $cpf,
        public string $sexo,
        public string $birth_date,
        public float $height,
        public float $weight
    ) {}
}
