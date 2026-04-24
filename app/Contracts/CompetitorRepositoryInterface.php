<?php

namespace App\Contracts;

interface CompetitorRepositoryInterface
{
    public function findByUserId(int $id);
}
