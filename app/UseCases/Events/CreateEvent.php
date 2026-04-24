<?php

namespace App\UseCases\Events;

use App\DTOs\CreateEventDTO;
use App\Enums\StatusEventsEnum;
use App\Repositories\EventRepository;
use App\Repositories\OrganizationRepository;
use DomainException;

class CreateEvent {

    public function __construct(
        private EventRepository $eventRepo,
        private OrganizationRepository $orgRepo
    ) {}

    public function execute(CreateEventDTO $dto)
    {
        $organization = $this->orgRepo->findByUserId($dto->userId);

        if (!$organization) {
            throw new DomainException('Usuário não é uma organização.');
        }

        return $this->eventRepo->create([
            'id_organization' => $organization->id,
            'title' => $dto->title,
            'description' => $dto->description,
            'event_date' => $dto->event_date,
            'vacancies' => $dto->vacancies,
            'route_km' => $dto->route_km,
            'route_description' => $dto->route_description,
            'status' => StatusEventsEnum::PUBLISHED
        ]);
    }
}
