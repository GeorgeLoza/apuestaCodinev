<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'api_id',
    'torneo_id',
    'equipo_local_id',
    'equipo_visitante_id',
    'grupo',
    'jornada',
    'tipo',
    'fecha_partido',
    'fecha_cierre_apuestas',
    'goles_local',
    'goles_visitante',
    'estado',
    'bloqueado',
])]
class FootballMatch  extends Model
{
    protected $table = 'partidos';

    protected function casts(): array
    {
        return [
            'fecha_partido' => 'datetime',
            'fecha_cierre_apuestas' => 'datetime',
            'bloqueado' => 'boolean',
        ];
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(
            Tournament::class,
            'torneo_id'
        );
    }

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(
            Team::class,
            'equipo_local_id'
        );
    }

    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(
            Team::class,
            'equipo_visitante_id'
        );
    }

    public function predictions(): HasMany
    {
        return $this->hasMany(
            Prediction::class,
            'partido_id'
        );
    }
}