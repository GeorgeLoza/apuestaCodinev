<?php

namespace App\Console\Commands;

use App\Services\Prediction\PredictionEvaluationService;
use Illuminate\Console\Command;

class EvaluatePredictionsCommand extends Command
{
    protected $signature = 'predictions:evaluate';

    protected $description = 'Evalua los pronosticos de los partidos finalizados y actualiza los puntos';

    public function handle(PredictionEvaluationService $service): int
    {
        $this->info('Evaluando pronósticos...');
        $service->execute();
        $this->info('Pronósticos evaluados con éxito.');
        return self::SUCCESS;
    }
}
