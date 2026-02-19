<?php

namespace App\Policies;

use App\Enums\UsersRoleEnum;
use App\Models\Organization;
use App\Models\User;

class OrganizationPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct(){}

    public function update(User $user, Organization $organization) : bool {
        return $user->id === $organization->id_user && $user->role === UsersRoleEnum::ORGANIZATOR;
    }

    public function delete(User $user, Organization $organization) : bool {
        return $user->id === $organization->id_user && $user->role === UsersRoleEnum::ORGANIZATOR;
    }
}
