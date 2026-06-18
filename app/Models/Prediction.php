<?php

namespace App\Models;

use App\Enums\ResultadoPronostico;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'partido_id',
    'goles_local',
    'goles_visitante',
    'puntos',
    'resultado',
])]
class Prediction extends Model
{
    protected $table = 'pronosticos';

    protected function casts(): array
    {
        return [
            'puntos' => 'integer',
            'resultado' => ResultadoPronostico::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }

    public function match(): BelongsTo
    {
        return $this->belongsTo(
            FootballMatch::class,
            'partido_id'
        );
    }
}