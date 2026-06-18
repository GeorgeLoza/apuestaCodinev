<?php

namespace App\DTOs;

class PronosticoDTO
{
    public function __construct(
        public readonly int $partidoId,
        public readonly int $golesLocal,
        public readonly int $golesVisitante,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            partidoId: (int) $data['partido_id'],
            golesLocal: (int) $data['goles_local'],
            golesVisitante: (int) $data['goles_visitante'],
        );
    }
}
