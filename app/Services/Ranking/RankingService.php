<?php

namespace App\Services\Ranking;

use App\Models\User;

class RankingService
{
    public function obtenerRanking()
    {
        return User::query()
            ->withSum(
                'predictions',
                'puntos'
            )
            ->orderByDesc(
                'predictions_sum_puntos'
            )
            ->get();
    }
}