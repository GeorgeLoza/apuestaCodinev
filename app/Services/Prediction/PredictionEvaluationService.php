<?php

namespace App\Services\Prediction;

use App\Models\FootballMatch;

class PredictionEvaluationService
{
    public function __construct(
        private PredictionScoringService $scoringService
    ) {}

    public function execute(): void
    {
        $partidos = FootballMatch::query()
            ->where('estado', 'finalizado')
            ->with('predictions')
            ->get();

        foreach ($partidos as $partido) {

            foreach ($partido->predictions as $prediction) {

                $resultado =
                    $this->scoringService->calcular(
                        $partido->goles_local,
                        $partido->goles_visitante,
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
}