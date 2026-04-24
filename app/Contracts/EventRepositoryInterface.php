<?php

namespace App\Contracts;

use App\Models\Event;

interface EventRepositoryInterface
{
    public function findWithLock(int $id) : ?Event;
}
