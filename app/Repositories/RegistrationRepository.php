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
}
