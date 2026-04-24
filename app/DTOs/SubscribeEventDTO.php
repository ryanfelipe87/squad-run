<?php

namespace App\DTOs;

class SubscribeEventDTO
{
    public function __construct(
        public int $eventId,
        public int $userId
    ){}
}
