<?php

namespace App\UseCases\Auth;

use Illuminate\Support\Facades\Auth;

class LogoutUser
{
    public function execute() : void
    {
        $user = Auth::user();

        $user->currentAccessToken()->delete();
    }
}
