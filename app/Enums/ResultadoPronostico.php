<?php

namespace App\Enums;

enum ResultadoPronostico:string
{
    case Exacto = 'exacto';

    case GanadorCorrecto = 'ganador_correcto';

    case Incorrecto = 'incorrecto';
}