<?php

namespace App\Repositories;

use App\Contracts\HomeRepositoryInterface;
use App\Enums\StatusEventsEnum;
use App\Models\CompetitorData;
use App\Models\Event;

class HomeRepository implements HomeRepositoryInterface
{
    public function getTotalKm() : float
    {
        return (float) CompetitorData::sum('total_km');
    }

    public function getTotalCompetitors() : int
    {
        return CompetitorData::count();
    }

    public function getFinishedEventsCount() : int
    {
        return Event::where('status', StatusEventsEnum::FINISHED)->count();
    }

    public function getNextEvents(int $limit = 3)
    {
        return Event::with('organization')
            ->where('event_date', '>=', now())
            ->where('status', StatusEventsEnum::PUBLISHED)
            ->orderBy('event_date')
            ->limit($limit)
            ->get();
    }
}