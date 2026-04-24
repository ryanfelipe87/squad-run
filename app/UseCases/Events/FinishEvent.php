<?php

namespace App\UseCases\Events;

use App\Enums\StatusEventsEnum;
use App\Repositories\EventRepository;
use App\Repositories\RegistrationRepository;
use DomainException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;

class FinishEvent {

    public function __construct(
        private EventRepository $eventRepo,
        private RegistrationRepository $registrationRepo
    ) {}

    public function execute(int $eventId, int $userId)
    {
        return DB::transaction(function () use ($eventId, $userId) {

            $event = $this->eventRepo->findWithLock($eventId);

            if (!$event) {
                throw new DomainException('Evento não encontrado.');
            }

            if ($event->organization->id_user !== $userId) {
                throw new AuthorizationException();
            }

            if ($event->status !== StatusEventsEnum::CLOSED) {
                throw new DomainException('Evento deve estar fechado primeiro.');
            }

            $hasPending = $this->registrationRepo
                ->hasPendingResults($event->id);

            if ($hasPending) {
                throw new DomainException('Existem resultados pendentes.');
            }

            return $this->eventRepo->update($event, [
                'status' => StatusEventsEnum::FINISHED
            ]);
        });
    }
}
