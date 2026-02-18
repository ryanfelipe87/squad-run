<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $table = 'organizations';

    protected $fillable = [
        'id_user',
        'name',
        'cnpj',
        'city',
        'state',
        'zip_code',
        'description'
    ];

    public function events(){
        return $this->hasMany(Event::class, 'id_organization');
    }
}
