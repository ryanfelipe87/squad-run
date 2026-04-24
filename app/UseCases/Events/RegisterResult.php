<?php

namespace App\UseCases\Events;

use App\DTOs\RegisterResultDTO;
use App\Enums\RegistrationStatusEnum;
use App\Enums\StatusEventsEnum;
use App\Jobs\UpdateCompetitorStatusJob;
use App\Repositories\EventRepository;
use App\Repositories\RegistrationRepository;
use DomainException;
use Illuminate\Support\Facades\DB;

class RegisterResult {

    public function __construct(
        private EventRepository $eventRepo,
        private RegistrationRepository $registrationRepo
    ) {}

    public function execute(RegisterResultDTO $dto)
    {
        return DB::transaction(function () use ($dto) {

            $event = $this->eventRepo->findById($dto->eventId);

            if (!$event || $event->status !== StatusEventsEnum::CLOSED) {
                throw new DomainException('Evento não encontrado ou não está fechado.');
            }

            $registration = $this->registrationRepo
                ->findWithLock($dto->eventId, $dto->competitorId);

            if ($registration->status === RegistrationStatusEnum::FINISHED) {
                throw new DomainException('Registro já finalizado.');
            }

            $updated = $this->registrationRepo->update($registration, [
                'total_time' => $dto->total_time,
                'traveled_km' => $dto->traveled_km,
                'position' => $dto->position,
                'status' => RegistrationStatusEnum::FINISHED
            ]);

            UpdateCompetitorStatusJob::dispatch(
                $dto->competitorId,
                $dto->eventId
            );

            return $updated;
        });
    }
}
