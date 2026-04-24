<?php

namespace App\UseCases\Events;

use App\Repositories\EventRepository;

class GetRanking {

    public function __construct(
        private EventRepository $eventRepo
    ) {}

    public function execute(int $eventId)
    {
        return $this->eventRepo->getRanking($eventId);
    }
}
