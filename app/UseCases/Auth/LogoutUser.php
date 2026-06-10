<?php

namespace App\UseCases\Auth;

use Illuminate\Support\Facades\Auth;

class LogoutUser
{
    public function execute() : void
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}
