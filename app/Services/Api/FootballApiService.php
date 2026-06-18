<?php

namespace App\Services\Api;

use App\DTOs\PartidoApiDTO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class FootballApiService
{
    public function obtenerPartidos(): Collection
    {
        $response = Http::withoutVerifying()
            ->acceptJson()
            ->timeout(60)
            ->retry(
                3,
                3000
            )
            ->get(
                config('football.base_url')
                    . '/get/games'
            );

        throw_if(
            ! $response->successful(),
            new \Exception('Error obteniendo partidos')
        );

        $games = $response->json('games');

        return collect($games)->map(
            fn(array $game) => PartidoApiDTO::fromArray($game)
        );
    }
}
