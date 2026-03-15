<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competitor extends Model
{
    use HasFactory;

    protected $table = 'competitors';

    protected $fillable = [
        'id_user',
        'cpf',
        'sexo',
        'birth_date',
        'weight',
        'height'
    ];

    public function registrations(){
        return $this->hasMany(Registrations::class, 'id_competitor');
    }

    public function status(){
        return $this->hasOne(CompetitorData::class, 'id_competitor');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }
}
