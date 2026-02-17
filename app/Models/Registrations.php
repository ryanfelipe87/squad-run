<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrations extends Model
{
    use HasFactory;

    protected $table = 'registrations';

    protected $fillable = [
        'id_event',
        'id_competitor',
        'status',
        'total_time',
        'traveled_km'
    ];
}
