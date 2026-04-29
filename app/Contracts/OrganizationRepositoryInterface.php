<?php

namespace App\Contracts;

use App\Models\Organization;

interface OrganizationRepositoryInterface {
    public function findById(int $id): ?Organization;
    public function findByUserId(int $userId): ?Organization;
    public function getAll();
    public function create(array $data): Organization;
    public function update(Organization $org, array $data): Organization;
    public function delete(Organization $org): void;
    public function hasEvents(int $organizationId): bool;
}
