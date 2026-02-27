<?php

namespace App\Enums;

enum StatusEventsEnum : string {
    case PUBLISHED = 'published';
    case CLOSED = 'closed';
    case DRAFT = 'draft';
    case FINISHED = 'finished';
    case CANCELED = 'canceled';
    case CONFIRMED = 'confirmed';
}
