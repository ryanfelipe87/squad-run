<?php

namespace App\UseCases\Subscribes;

use App\Contracts\CompetitorRepositoryInterface;
use App\Contracts\EventRepositoryInterface;
use App\Contracts\RegistrationRepositoryInterface;
use App\DTOs\SubscribeEventDTO;
use App\Enums\RegistrationStatusEnum;
use App\Enums\StatusEventsEnum;
use App\Jobs\SendRegistrationEmailJob;
use DomainException;
use Illuminate\Support\Facades\DB;

class SubscribeCompetitor
{
    public function __construct(
        private EventRepositoryInterface $eventRepo,
        private CompetitorRepositoryInterface $competitorRepo,
        private RegistrationRepositoryInterface $registrationRepo
    ) {}

    public function execute(SubscribeEventDTO $dto)
    {
        return DB::transaction(function () use ($dto) {

            $event = $this->eventRepo->findWithLock($dto->eventId);

            if (!$event) {
                throw new DomainException('Event not found');
            }

            if ($event->status !== StatusEventsEnum::PUBLISHED) {
                throw new DomainException('Event not available');
            }

            if ($event->event_date < now()) {
                throw new DomainException('Event already happened');
            }

            $competitor = $this->competitorRepo->findByUserId($dto->userId);

            if (!$competitor) {
                throw new DomainException('User is not a competitor');
            }

            if ($this->registrationRepo->exists($event->id, $competitor->id)) {
                throw new DomainException('Already enrolled');
            }

            $registrationsCount = $this->registrationRepo
                ->countByEventWithLock($event->id);

            if ($registrationsCount >= $event->vacancies) {
                throw new DomainException('No vacancies available');
            }

            $registration = $this->registrationRepo->create([
                'id_event' => $event->id,
                'id_competitor' => $competitor->id,
                'status' => RegistrationStatusEnum::CONFIRMED,
                'total_time' => 0.0,
                'traveled_km' => 0.0
            ]);

            DB::afterCommit(function () use ($event, $competitor) {
                SendRegistrationEmailJob::dispatch($event, $competitor);
            });

            return $registration;
        });
    }
}
