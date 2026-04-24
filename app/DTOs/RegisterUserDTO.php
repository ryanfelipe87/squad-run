<?php

namespace App\DTOs;

class RegisterUserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $role
    ){}
}
