<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'nombre',
    'descripcion',
    'estado',
    'fecha_inicio',
    'fecha_fin',
])]
class Tournament extends Model
{
    protected $table = 'torneos';

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
        ];
    }

    public function matches(): HasMany
    {
        return $this->hasMany(FootballMatch::class,'torneo_id');
    }
}