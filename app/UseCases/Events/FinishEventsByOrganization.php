<?php

namespace App\UseCases\Events;

use App\Repositories\EventRepository;
use App\UseCases\Events\FinishEvent;

class FinishEventsByOrganization
{
    public function __construct(
        private EventRepository $repository,
        private FinishEvent $finishEvent
    ) {}

    public function execute(int $organizationId, int $userId): void
    {
        $events = $this->repository->getClosedByOrganization($organizationId);

        foreach ($events as $event) {
            $this->finishEvent->execute($event->id, $userId);
        }
    }
}
