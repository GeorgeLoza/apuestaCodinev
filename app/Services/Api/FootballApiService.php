<?php

namespace App\Services\Api;

use App\DTOs\PartidoApiDTO;
use App\Helpers\StadiumTimezoneHelper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class FootballApiService
{
    public function obtenerPartidos(): Collection
    {
        // 1. PARTIDOS
        $gamesResponse = Http::withoutVerifying()
            ->acceptJson()
            ->timeout(60)
            ->retry(3, 3000)
            ->get(config('football.base_url') . '/get/games');

        throw_if(
            ! $gamesResponse->successful(),
            new \Exception('Error obteniendo partidos')
        );

        // 2. ESTADIOS
        $stadiumsResponse = Http::withoutVerifying()
            ->acceptJson()
            ->timeout(60)
            ->retry(3, 3000)
            ->get(config('football.base_url') . '/get/stadiums');

        throw_if(
            ! $stadiumsResponse->successful(),
            new \Exception('Error obteniendo estadios')
        );

        $stadiums = collect($stadiumsResponse->json('stadiums'))
            ->keyBy('id');

        $games = $gamesResponse->json('games');

        // 3. MAPEO FINAL
        return collect($games)->map(function (array $game) use ($stadiums) {

            $stadium = $stadiums->get($game['stadium_id'] ?? null);

            return PartidoApiDTO::fromArray($game, $stadium);
        });
    }
}