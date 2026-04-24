<?php

namespace App\DTOs;

class CreateEventDTO {
    public function __construct(
        public int $userId,
        public string $title,
        public string $description,
        public string $event_date,
        public int $vacancies,
        public float $route_km,
        public string $route_description,
        public string $status
    ) {}
}
