<?php

namespace App\Actions;

use App\Models\FootballMatch;
use App\Models\Team;
use App\Models\Tournament;
use App\Services\Api\FootballApiService;
use Illuminate\Support\Facades\Cache;

class SyncMatchesAction
{
    public function __construct(
        private FootballApiService $footballApiService
    ) {}

    public function execute(): void
    {
        $torneo = Tournament::where(
            'estado',
            'activo'
        )->firstOrFail();

        $partidos = $this->footballApiService
            ->obtenerPartidos();

        foreach ($partidos as $dto) {

            $equipoLocal = null;
            $equipoVisitante = null;

            /*
            |--------------------------------------------------------------------------
            | Equipo Local
            |--------------------------------------------------------------------------
            */
            if ($dto->homeTeamApiId > 0) {

                $equipoLocal = Team::firstOrCreate(
                    [
                        'api_id' => $dto->homeTeamApiId,
                    ],
                    [
                        'nombre' => $dto->homeTeam,
                    ]
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Equipo Visitante
            |--------------------------------------------------------------------------
            */
            if ($dto->awayTeamApiId > 0) {

                $equipoVisitante = Team::firstOrCreate(
                    [
                        'api_id' => $dto->awayTeamApiId,
                    ],
                    [
                        'nombre' => $dto->awayTeam,
                    ]
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Partido
            |--------------------------------------------------------------------------
            */
            FootballMatch::updateOrCreate(
                [
                    'api_id' => $dto->apiId,
                ],
                [
                    'torneo_id' => $torneo->id,

                    'equipo_local_id' => $equipoLocal?->id,
                    'equipo_visitante_id' => $equipoVisitante?->id,

                    'local_label' => $dto->homeTeamApiId === 0
                        ? $dto->homeTeam
                        : null,

                    'visitante_label' => $dto->awayTeamApiId === 0
                        ? $dto->awayTeam
                        : null,

                    'grupo' => $dto->group,

                    'jornada' => $dto->matchday,

                    'tipo' => $dto->type,

                    /*
                    |--------------------------------------------------------------------------
                    | Hora ya convertida a Bolivia
                    |--------------------------------------------------------------------------
                    */
                    'fecha_partido' => $dto->matchDate,

                    'fecha_cierre_apuestas' => $dto->matchDate
                        ->copy()
                        ->subMinute(),

                    'goles_local' => $dto->homeScore,

                    'goles_visitante' => $dto->awayScore,

                    'estado' => $dto->finished
                        ? 'finalizado'
                        : 'programado',
                ]
            );
        }

        Cache::put('football_api_last_sync', now()->toDateTimeString());
    }
}