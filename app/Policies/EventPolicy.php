<?php

namespace App\Policies;

use App\Enums\UsersRoleEnum;
use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct(){}

    public function viewAny(User $user) : bool{
        return true;
    }

    public function create(User $user) : bool{
        return $user->role === UsersRoleEnum::ORGANIZATOR;
    }

    public function update(User $user, Event $event) : bool{
        return $user->role === UsersRoleEnum::ORGANIZATOR && $event->organization->id_user === $user->id;
    }

    public function delete(User $user, Event $event) : bool{
        return $user->role === UsersRoleEnum::ORGANIZATOR && $event->organization->id_user === $user->id;
    }
}
