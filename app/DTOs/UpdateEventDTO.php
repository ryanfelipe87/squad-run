<?php

namespace App\DTOs;

class UpdateEventDTO
{
    public function __construct(
        public ?int $userId = null,
        public ?string $title = null,
        public ?string $description = null,
        public ?string $event_date = null,
        public ?int $vacancies = null,
        public ?float $route_km = null,
        public ?string $route_description = null,
        public ?string $status = null
    ){}
}
