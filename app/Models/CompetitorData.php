<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitorData extends Model
{
    use HasFactory;

    protected $table = 'competitor_data';

    protected $fillable = [
        'id_competitor',
        'total_km',
        'total_runs',
        'best_time',
        'awards_winner'
    ];
}
