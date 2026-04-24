<?php

namespace App\DTOs;

class UpdateUserDTO
{
    public function __construct(
        public ?string $name = null,
        public ?string $email = null
    ){}
}
