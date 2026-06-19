<?php

namespace App\Models;

use App\Models\Prediction;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'pronostico_id',
    'monto',
    'estado',
    'metodo',
    'nota',
    'pagado_en',
])]
class Payment extends Model
{
    protected $table = 'pagos';

    protected function casts(): array
    {
        return [
            'monto' => 'decimal:2',
            'pagado_en' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function prediction(): BelongsTo
    {
        return $this->belongsTo(Prediction::class, 'pronostico_id');
    }
}
