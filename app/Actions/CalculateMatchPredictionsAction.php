<?php

namespace App\Actions;

use App\Models\FootballMatch;
use App\Services\Prediction\PredictionScoringService;

class CalculateMatchPredictionsAction
{
    public function __construct(
        private PredictionScoringService $scoringService
    ) {}

    public function execute(
        FootballMatch $match
    ): void {

        foreach (
            $match->predictions as $prediction
        ) {

            $resultado = $this->scoringService
                ->calcular(
                    $match->goles_local,
                    $match->goles_visitante,
                    $prediction->goles_local,
                    $prediction->goles_visitante
                );

            $prediction->update([
                'puntos' => $resultado['puntos'],
                'resultado' => $resultado['resultado'],
            ]);
        }
    }
}