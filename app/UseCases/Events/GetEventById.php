<?php

namespace App\UseCases\Events;

use App\Repositories\EventRepository;
use DomainException;

class GetEventById
{
    public function __construct(
        private EventRepository $repository
    ) {}

    public function execute(int $id)
    {
        $event = $this->repository->findById($id);

        if (!$event) {
            throw new DomainException('Evento não encontrado.');
        }

        return $event;
    }
}
