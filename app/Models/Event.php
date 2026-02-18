<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'id_organization',
        'title',
        'description',
        'event_date',
        'vacancies',
        'route_km',
        'route_description'
    ];
}
