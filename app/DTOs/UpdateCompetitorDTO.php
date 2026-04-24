<?php

namespace App\DTOs;

class UpdateCompetitorDTO {
    public function __construct(
        public ?string $cpf = null,
        public ?string $sexo = null,
        public ?string $birth_date = null,
        public ?float $height = null,
        public ?float $weight = null
    ) {}
}
