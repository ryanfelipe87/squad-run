<?php

namespace App\DTOs;

class RegisterResultDTO {
    public function __construct(
        public int $eventId,
        public int $competitorId,
        public float $total_time,
        public float $traveled_km,
        public int $position
    ) {}
}
