<?php

namespace App\Enums;

enum TipoPartido:string
{
    case Grupo = 'grupo';

    case Dieciseisavos = 'dieciseisavos';

    case Octavos = 'octavos';

    case Cuartos = 'cuartos';

    case Semifinal = 'semifinal';

    case TercerPuesto = 'tercer_puesto';

    case Final = 'final';
}