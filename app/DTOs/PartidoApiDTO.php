<?php

namespace App\DTOs;

use App\Helpers\StadiumTimezoneHelper;
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

        public readonly Carbon $matchDate,

        public readonly bool $finished,
        public readonly string $type,

        public readonly ?array $stadium = null,
    ) {}

    public static function fromArray(
        array $data,
        ?array $stadium = null
    ): self {

        /*
        |--------------------------------------------------------------------------
        | Timezone según estadio
        |--------------------------------------------------------------------------
        */
        $timezone = 'UTC';

if (
    $stadium !== null &&
    isset($stadium['city_en'])
) {
    $timezone = StadiumTimezoneHelper::getTimezone(
        $stadium['city_en']
    );
}

$matchDate = Carbon::createFromFormat(
    'm/d/Y H:i',
    $data['local_date'],
    $timezone
)->setTimezone('America/La_Paz');


        return new self(
            apiId: (int) $data['id'],

            homeTeamApiId: (int) $data['home_team_id'],
            awayTeamApiId: (int) $data['away_team_id'],

            homeTeam: $data['home_team_name_en']
                ?? $data['home_team_label']
                ?? 'Por definir',

            awayTeam: $data['away_team_name_en']
                ?? $data['away_team_label']
                ?? 'Por definir',

            homeScore: is_numeric($data['home_score'])
                ? (int) $data['home_score']
                : null,

            awayScore: is_numeric($data['away_score'])
                ? (int) $data['away_score']
                : null,

            group: $data['group'],

            matchday: (int) $data['matchday'],

            matchDate: $matchDate,

            finished: strtoupper(
                (string) $data['finished']
            ) === 'TRUE',

            type: $data['type'],

            stadium: $stadium,
        );
    }
}