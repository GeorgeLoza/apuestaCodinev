<?php

namespace App\Enums;

enum EstadoTorneo:string
{
    case Borrador = 'borrador';

    case Activo = 'activo';

    case Finalizado = 'finalizado';
}