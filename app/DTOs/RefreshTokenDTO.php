<?php

namespace App\DTOs;

class RefreshTokenDTO
{
    public function __construct(
        public string $refresh_token
    ){}
}
