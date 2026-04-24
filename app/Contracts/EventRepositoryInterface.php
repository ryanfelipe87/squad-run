<?php

namespace App\Contracts;

use App\Models\Event;

interface EventRepositoryInterface
{
    public function findWithLock(int $id) : ?Event;
    public function findById(int $id) : ?Event;
    public function create(array $data) : Event;
    public function update(Event $event, array $data) : ?Event;
    public function delete(Event $event) : void;
    public function getAll();
    public function getRanking(int $eventId);
}
