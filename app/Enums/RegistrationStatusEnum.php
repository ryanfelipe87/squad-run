<?php

namespace App\Enums;

enum RegistrationStatusEnum : string {
    case CONFIRMED = 'confirmed';
    case CANCELED = 'canceled';
    case FINISHED = 'finished';
}
