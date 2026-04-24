<?php

namespace App\Repositories;

use App\Models\Organization;

class OrganizationRepository
{
    public function findByUserId(int $userId)
    {
        return Organization::where('user_id', $userId)->first();
    }
}
