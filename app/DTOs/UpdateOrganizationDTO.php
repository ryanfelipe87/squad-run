<?php

namespace App\DTOs;

class UpdateOrganizationDTO {
    public function __construct(
        public ?string $name = null,
        public ?string $cnpj = null,
        public ?string $city = null,
        public ?string $state = null,
        public ?string $zip_code = null,
        public ?string $description = null
    ) {}
}
