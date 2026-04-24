<?php

namespace App\Repositories;

use App\Contracts\CompetitorRepositoryInterface;
use App\Models\Competitor;

class CompetitorRepository implements CompetitorRepositoryInterface
{
    public function getAll() {
        return Competitor::orderBy('id')->get();
    }

    public function findById(int $id): ?Competitor {
        return Competitor::find($id);
    }

    public function findByUserId(int $userId): ?Competitor {
        return Competitor::where('id_user', $userId)->first();
    }

    public function create(array $data): Competitor {
        return Competitor::create($data);
    }

    public function update(Competitor $competitor, array $data): Competitor {
        $competitor->update($data);
        return $competitor;
    }

    public function delete(Competitor $competitor): void {
        $competitor->delete();
    }

    public function getEventsByUserId(int $userId){
        return Competitor::where('id_user', $userId)
            ->with('registrations.event')
            ->first()?->registrations
            ->pluck('event');
    }
}
