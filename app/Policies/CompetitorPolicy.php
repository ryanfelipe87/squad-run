<?php

namespace App\Policies;

use App\Enums\StatusEventsEnum;
use App\Enums\UsersRoleEnum;
use App\Models\Competitor;
use App\Models\Event;
use App\Models\User;

class CompetitorPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct(){}

    public function update(User $user, Competitor $competitor) : bool {
        return $competitor->id_user === $user->id && $user->role === UsersRoleEnum::PARTICIPANT;
    }

    public function delete(User $user, Competitor $competitor) : bool {
        return $competitor->id_user === $user->id && $user->role === UsersRoleEnum::PARTICIPANT;
    }

    public function subscribeEvent(User $user, Event $event) : bool {
        return $user->role === UsersRoleEnum::PARTICIPANT && $event->status === StatusEventsEnum::PUBLISHED;
    }
}
