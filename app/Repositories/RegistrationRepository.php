<?php

namespace App\Repositories;

use App\Contracts\RegistrationRepositoryInterface;
use App\Models\Registrations;

class RegistrationRepository implements RegistrationRepositoryInterface {

    public function exists(int $eventId, int $competitorId): bool {
        return Registrations::where('id_event', $eventId)
            ->where('id_competitor', $competitorId)
            ->exists();
    }

    public function countByEventWithLock(int $eventId): int {
        return Registrations::where('id_event', $eventId)
            ->lockForUpdate()
            ->count();
    }

    public function create(array $data): Registrations {
        return Registrations::create($data);
    }

    public function hasPendingResults(int $eventId): bool {
        return Registrations::where('id_event', $eventId)
            ->whereNull('result')
            ->exists();
    }

    public function findWithLock(int $eventId, int $competitorId): ?Registrations {
        return Registrations::where('id_event', $eventId)
            ->where('id_competitor', $competitorId)
            ->lockForUpdate()
            ->first();
    }

    public function update(Registrations $registration, array $data): ?Registrations {
        $registration->update($data);
        return $registration;
    }
}
