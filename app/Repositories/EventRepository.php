<?php

namespace App\Repositories;

use App\Contracts\EventRepositoryInterface;
use App\Models\Event;

class EventRepository implements EventRepositoryInterface {

    public function findWithLock(int $id): ?Event {
        return Event::where('id', $id)
            ->lockForUpdate()
            ->first();
    }
}
