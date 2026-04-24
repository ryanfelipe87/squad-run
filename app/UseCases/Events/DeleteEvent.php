<?php

namespace App\UseCases\Events;

use App\Repositories\EventRepository;
use DomainException;

class DeleteEvent
{
    public function __construct(
        private EventRepository $repository
    ) {}

    public function execute(int $id): void
    {
        $event = $this->repository->findById($id);

        if (!$event) {
            throw new DomainException('Evento não encontrado.');
        }

        $this->repository->delete($event);
    }
}
