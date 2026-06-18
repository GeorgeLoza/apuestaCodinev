<?php

namespace App\DTOs;

use Carbon\Carbon;

class PartidoApiDTO
{
    public function __construct(
        public readonly int $apiId,

        public readonly int $homeTeamApiId,
        public readonly int $awayTeamApiId,

        public readonly string $homeTeam,
        public readonly string $awayTeam,

        public readonly ?int $homeScore,
        public readonly ?int $awayScore,

        public readonly string $group,
        public readonly int $matchday,

        // 🔥 UNA SOLA FECHA REAL YA CONVERTIDA
        public readonly Carbon $matchDate,

        public readonly bool $finished,
        public readonly string $type,

        public readonly ?array $stadium = null,
    ) {}

    public static function fromArray(array $data, ?array $stadium = null): self
    {
        /*
         * 🧠 1. Parseo de fecha original API
         * Formato API: "06/11/2026 13:00"
         */
        $rawDate = Carbon::createFromFormat(
            'm/d/Y H:i',
            $data['local_date'],
            'UTC' // asumimos base UTC
        );

        /*
         * 🧠 2. Si quieres lógica por estadio (opcional)
         * si no tienes timezone real por ciudad → UTC
         */
        if ($stadium) {
            $timezone = match ($stadium['country_en'] ?? '') {
                'Mexico' => 'America/Mexico_City',
                'United States' => 'America/New_York', // base general (puedes mejorar por ciudad)
                'Canada' => 'America/Toronto',
                default => 'UTC',
            };

            $rawDate->setTimezone($timezone);
        }

        /*
         * 🔥 3. CONVERSIÓN FINAL A LA PAZ
         */
        $matchDate = $rawDate->setTimezone('America/La_Paz');

        return new self(
            apiId: (int) $data['id'],

            homeTeamApiId: (int) $data['home_team_id'],
            awayTeamApiId: (int) $data['away_team_id'],

            homeTeam: $data['home_team_name_en'] ?? 'Por definir',
            awayTeam: $data['away_team_name_en'] ?? 'Por definir',

            homeScore: is_numeric($data['home_score']) ? (int) $data['home_score'] : null,
            awayScore: is_numeric($data['away_score']) ? (int) $data['away_score'] : null,

            group: $data['group'],
            matchday: (int) $data['matchday'],

            // 🔥 ESTE ES EL IMPORTANTE
            matchDate: $matchDate,

            finished: strtoupper($data['finished']) === 'TRUE',
            type: $data['type'],

            stadium: $stadium,
        );
    }
}