<?php

namespace App\UseCases\Events;

use App\DTOs\UpdateEventDTO;
use App\Repositories\EventRepository;
use DomainException;

class UpdateEvent
{
    public function __construct(
        private EventRepository $repository
    ) {}

    public function execute(int $id, UpdateEventDTO $dto)
    {
        $event = $this->repository->findById($id);

        if (!$event) {
            throw new DomainException('Evento não encontrado.');
        }

        $data = array_filter([
            'title' => $dto->title,
            'description' => $dto->description,
            'event_date' => $dto->event_date,
            'vacancies' => $dto->vacancies,
            'route_km' => $dto->route_km,
            'route_description' => $dto->route_description,
            'status' => $dto->status
        ], fn($value) => !is_null($value));

        return $this->repository->update($event, $data);
    }
}
