<?php

namespace App\UseCases\Events;

use App\Repositories\EventRepository;

class GetAllEvents
{
    public function __construct(
        private EventRepository $repository
    ) {}

    public function execute()
    {
        return $this->repository->getAll();
    }
}
