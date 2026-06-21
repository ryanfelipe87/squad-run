<?php

namespace App\Contracts;

interface HomeRepositoryInterface
{
    public function getTotalKm() : float;
    public function getTotalCompetitors() : int;
    public function getFinishedEventsCount() : int;
    public function getNextEvents(int $limit = 3);
}