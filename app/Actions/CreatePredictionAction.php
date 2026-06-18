<?php

namespace App\Actions;

use App\Models\FootballMatch;
use App\Models\Prediction;
use Carbon\Carbon;

class CreatePredictionAction
{
    public function execute(
        int $userId,
        int $partidoId,
        int $golesLocal,
        int $golesVisitante
    ): Prediction {

        $partido = FootballMatch::findOrFail(
            $partidoId
        );

        if (
            Carbon::now()->greaterThanOrEqualTo(
                $partido->fecha_cierre_apuestas
            )
        ) {
            throw new \Exception(
                'Las apuestas están cerradas.'
            );
        }

        return Prediction::updateOrCreate(
            [
                'user_id' => $userId,
                'partido_id' => $partidoId,
            ],
            [
                'goles_local' => $golesLocal,
                'goles_visitante' => $golesVisitante,
            ]
        );
    }
}