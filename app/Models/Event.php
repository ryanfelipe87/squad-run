<?php

namespace App\Models;

use App\Enums\StatusEventsEnum;
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
        'route_description',
        'status'
    ];

    public function organization(){
        return $this->belongsTo(Organization::class, 'id_organization');
    }

    public function registrations(){
        return $this->hasMany(Registrations::class, 'id_event');
    }

    protected $casts = [
        'status' => StatusEventsEnum::class
    ];
}
