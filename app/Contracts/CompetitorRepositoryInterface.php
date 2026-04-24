<?php

namespace App\Contracts;

use App\Models\Competitor;

interface CompetitorRepositoryInterface
{
    public function getAll();
    public function findById(int $id) : ?Competitor;
    public function findByUserId(int $userId) : ?Competitor;
    public function create(array $data) : Competitor;
    public function update(Competitor $competitor, array $data) : ?Competitor;
    public function delete(Competitor $competitor) : void;
}
