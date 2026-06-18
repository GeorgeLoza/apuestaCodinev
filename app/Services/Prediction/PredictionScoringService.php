<?php

namespace App\Services\Prediction;

class PredictionScoringService
{
    public function calcular(
        int $golesLocalReal,
        int $golesVisitanteReal,
        int $golesLocalPronosticado,
        int $golesVisitantePronosticado
    ): array {

        if (
            $golesLocalReal === $golesLocalPronosticado
            &&
            $golesVisitanteReal === $golesVisitantePronosticado
        ) {

            return [
                'puntos' => 3,
                'resultado' => 'exacto'
            ];
        }

        $resultadoReal =
            $golesLocalReal <=> $golesVisitanteReal;

        $resultadoPronosticado =
            $golesLocalPronosticado <=> $golesVisitantePronosticado;

        if (
            $resultadoReal === $resultadoPronosticado
        ) {

            return [
                'puntos' => 1,
                'resultado' => 'ganador_correcto'
            ];
        }

        return [
            'puntos' => 0,
            'resultado' => 'incorrecto'
        ];
    }
}