<?php

namespace App\DTOs;

class CreateOrganizationDTO {
    public function __construct(
        public int $userId,
        public string $name,
        public string $cnpj,
        public string $city,
        public string $state,
        public string $zip_code,
        public string $description
    ) {}
}
