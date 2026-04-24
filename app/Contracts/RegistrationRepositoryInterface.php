<?php

namespace App\Contracts;

use App\Models\Registrations;

interface RegistrationRepositoryInterface
{
    public function exists(int $userId, int $eventId) : bool;
    public function countByEventWithLock(int $eventId) : int;
    public function create(array $data) : Registrations;
}
