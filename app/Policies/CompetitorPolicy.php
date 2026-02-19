<?php

namespace App\Policies;

use App\Models\Competitor;
use App\Models\User;

class CompetitorPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct(){}

    public function update(User $user, Competitor $competitor) : bool {
        return $user->id === $competitor->id_user || $competitor->event->organization->id_user === $user->id;
    }

    public function delete(User $user, Competitor $competitor) : bool {
        return $user->id === $competitor->id_user || $competitor->event->organization->id_user === $user->id;
    }
}
