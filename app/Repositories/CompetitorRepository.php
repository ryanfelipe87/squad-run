<?php

namespace App\Repositories;

use App\Contracts\CompetitorRepositoryInterface;
use App\Models\Competitor;

class CompetitorRepository implements CompetitorRepositoryInterface
{
    public function findByUserId(int $id)
    {
        return Competitor::find($id);
    }
}
