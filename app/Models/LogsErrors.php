<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogsErrors extends Model
{
    use HasFactory;

    protected $table = 'logs_errors';

    protected $fillable = [
        'route',
        'erro',
        'user'
    ];
}
