<?php

namespace App\Repositories;

use App\Contracts\OrganizationRepositoryInterface;
use App\Models\Organization;

class OrganizationRepository implements OrganizationRepositoryInterface
{

    public function findById(int $id): ?Organization {
        return Organization::find($id);
    }

    public function findByUserId(int $userId): ?Organization {
        return Organization::where('id_user', $userId)->first();
    }

    public function getAll() {
        return Organization::all();
    }

    public function create(array $data): Organization {
        return Organization::create($data);
    }

    public function update(Organization $org, array $data): Organization {
        $org->update($data);
        return $org;
    }

    public function delete(Organization $org): void {
        $org->delete();
    }

    public function hasEvents(int $organizationId): bool {
        return Organization::where('id', $organizationId)
            ->whereHas('events')
            ->exists();
    }
}
