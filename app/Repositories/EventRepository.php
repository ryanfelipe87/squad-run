<?php

namespace App\Repositories;

use App\Contracts\EventRepositoryInterface;
use App\Enums\StatusEventsEnum;
use App\Models\Event;

class EventRepository implements EventRepositoryInterface {

    public function findById(int $id): ?Event {
        return Event::find($id);
    }

    public function findWithLock(int $id): ?Event {
        return Event::where('id', $id)->lockForUpdate()->first();
    }

    public function create(array $data): Event {
        return Event::create($data);
    }

    public function update(Event $event, array $data): Event {
        $event->update($data);
        return $event;
    }

    public function delete(Event $event): void {
        $event->delete();
    }

    public function getAll() {
        return Event::orderBy('id')->get();
    }

    public function getRanking(int $eventId) {
        return Event::find($eventId)
            ->registrations()
            ->with('competitor.user')
            ->whereNotNull('total_time')
            ->orderBy('total_time')
            ->get();
    }

    public function getClosedByOrganization(int $organizationId) {
        return Event::where('organization_id', $organizationId)
            ->where('status', StatusEventsEnum::CLOSED)
            ->get();
    }
}
