<?php

namespace App\Enums;

enum EstadoPartido:string
{
    case Programado = 'programado';

    case EnJuego = 'en_juego';

    case Finalizado = 'finalizado';

    case Suspendido = 'suspendido';
}