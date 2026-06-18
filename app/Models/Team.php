<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'api_id',
    'nombre',
    'codigo',
    'bandera',
])]
class Team extends Model
{
    protected $table = 'equipos';

    public function homeMatches(): HasMany
    {
        return $this->hasMany(
            FootballMatch::class,
            'equipo_local_id'
        );
    }

    public function awayMatches(): HasMany
    {
        return $this->hasMany(
            FootballMatch::class,
            'equipo_visitante_id'
        );
    }
}