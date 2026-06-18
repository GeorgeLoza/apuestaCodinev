<div class="max-w-6xl mx-auto p-4 md:p-8 space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-zinc-200 dark:border-zinc-700 pb-6">
        <div>
            <flux:heading size="xl" level="1" class="font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-500">
                Pronósticos del Mundial 2026
            </flux:heading>
            <flux:text class="text-zinc-500 dark:text-zinc-400 mt-1">
                Ingresa tus predicciones para los partidos y acumula puntos. ¡El que obtenga más puntos gana!
            </flux:text>
        </div>
        
        <!-- Filters -->
        <div class="flex flex-wrap items-center gap-3">
            <div class="w-48">
                <flux:select wire:model.live="selectedPhase" placeholder="Filtrar por fase">
                    @foreach($phases as $val => $label)
                        <flux:select.option value="{{ $val }}">{{ $label }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            
            <div class="w-48">
                <flux:select wire:model.live="predictionFilter" placeholder="Estado pronóstico">
                    <flux:select.option value="todos">Todos los partidos</flux:select.option>
                    <flux:select.option value="pronosticados">Pronosticados</flux:select.option>
                    <flux:select.option value="pendientes">Pendientes por apostar</flux:select.option>
                </flux:select>
            </div>
        </div>
    </div>

    <!-- Match Grid -->
    @if($matches->isEmpty())
        <div class="flex flex-col items-center justify-center p-12 bg-zinc-50 dark:bg-zinc-900 border border-dashed border-zinc-300 dark:border-zinc-700 rounded-2xl text-center">
            <flux:icon name="calendar" class="size-12 text-zinc-400 mb-4" />
            <flux:heading size="lg">No se encontraron partidos</flux:heading>
            <flux:text class="mt-1">Prueba cambiando los filtros seleccionados.</flux:text>
        </div>
    @else
        <div class="grid gap-6 md:grid-cols-2">
            @foreach($matches as $match)
                @php
                    $userPrediction = $match->predictions->first();
                    $isBetsClosed = \Carbon\Carbon::now()->greaterThanOrEqualTo($match->fecha_cierre_apuestas);
                    $isFinished = $match->estado === 'finalizado';
                @endphp

                <flux:card class="relative overflow-hidden border border-zinc-200 dark:border-zinc-700/80 bg-white dark:bg-zinc-900 shadow-sm transition-all duration-300 hover:shadow-md hover:border-zinc-300 dark:hover:border-zinc-600 rounded-2xl flex flex-col justify-between">
                    <!-- Top Ribbon/Header -->
                    <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800/80 pb-3 mb-4 text-xs font-semibold text-zinc-500 dark:text-zinc-400">
                        <span class="flex items-center gap-1.5 uppercase tracking-wider">
                            <flux:badge size="sm" color="zinc" class="font-bold">
                                {{ strtoupper($match->tipo) }}
                            </flux:badge>
                            @if($match->grupo)
                                <span>• Grupo {{ $match->grupo }}</span>
                            @endif
                            @if($match->jornada)
                                <span>• Jornada {{ $match->jornada }}</span>
                            @endif
                        </span>
                        <span>
                            {{ $match->fecha_partido->format('d M Y, H:i') }}
                        </span>
                    </div>

                    <!-- Teams & Inputs Core Row -->
                    <div class="grid grid-cols-12 gap-2 items-center py-2 flex-grow">
                        <!-- Home Team -->
                        <div class="col-span-4 flex flex-col items-center text-center space-y-2">
                            @if($match->homeTeam)
                                <img src="{{ $match->homeTeam->getFlagUrl() }}" alt="{{ $match->homeTeam->nombre }}" class="h-8 w-12 object-cover rounded shadow-sm border border-zinc-200 dark:border-zinc-700">
                                <span class="font-bold text-sm text-zinc-800 dark:text-zinc-100 line-clamp-2">{{ $match->homeTeam->nombre }}</span>
                            @else
                                <div class="h-8 w-12 flex items-center justify-center bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded shadow-sm">
                                    <span class="text-zinc-400 font-bold">?</span>
                                </div>
                                <span class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 italic line-clamp-2">{{ $match->local_label ?? 'Por definir' }}</span>
                            @endif
                        </div>

                        <!-- Match/Prediction Score -->
                        <div class="col-span-4 flex flex-col items-center justify-center space-y-3">
                            @if($isBetsClosed)
                                <!-- Bets Closed Interface -->
                                <div class="flex items-center justify-center space-x-2">
                                    <!-- User Prediction -->
                                    <div class="flex flex-col items-center bg-zinc-50 dark:bg-zinc-800 px-3 py-1.5 rounded-lg border border-zinc-200 dark:border-zinc-700">
                                        <span class="text-[10px] uppercase font-bold text-zinc-400">Tu apuesta</span>
                                        <span class="font-black text-sm text-zinc-700 dark:text-zinc-200">
                                            {{ $userPrediction ? "{$userPrediction->goles_local} - {$userPrediction->goles_visitante}" : '- -' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Real Score if Finished/In Play -->
                                @if($isFinished || $match->estado === 'en_juego')
                                    <div class="text-center">
                                        <span class="text-[10px] uppercase font-bold text-zinc-400 block">Resultado Real</span>
                                        <span class="text-lg font-black tracking-wider text-zinc-900 dark:text-white">
                                            {{ $match->goles_local }} - {{ $match->goles_visitante }}
                                        </span>
                                        @if($match->estado === 'en_juego')
                                            <flux:badge size="sm" color="amber" class="animate-pulse font-bold mt-1">En Vivo</flux:badge>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-center">
                                        <flux:badge size="sm" color="zinc" class="font-bold">Cerrado</flux:badge>
                                    </div>
                                @endif
                            @else
                                <!-- Bets Open Interface -->
                                <div class="flex items-center justify-center space-x-1.5">
                                    <input 
                                        type="number" 
                                        wire:model="predictions.{{ $match->id }}.goles_local"
                                        class="w-12 text-center font-bold text-lg bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg py-1 focus:ring-2 focus:ring-emerald-500 focus:outline-hidden"
                                        min="0"
                                        max="20"
                                    >
                                    <span class="font-bold text-zinc-400">-</span>
                                    <input 
                                        type="number" 
                                        wire:model="predictions.{{ $match->id }}.goles_visitante"
                                        class="w-12 text-center font-bold text-lg bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg py-1 focus:ring-2 focus:ring-emerald-500 focus:outline-hidden"
                                        min="0"
                                        max="20"
                                    >
                                </div>
                                <span class="text-[10px] text-zinc-400 uppercase font-semibold text-center tracking-wider">Pronosticar</span>
                            @endif
                        </div>

                        <!-- Away Team -->
                        <div class="col-span-4 flex flex-col items-center text-center space-y-2">
                            @if($match->awayTeam)
                                <img src="{{ $match->awayTeam->getFlagUrl() }}" alt="{{ $match->awayTeam->nombre }}" class="h-8 w-12 object-cover rounded shadow-sm border border-zinc-200 dark:border-zinc-700">
                                <span class="font-bold text-sm text-zinc-800 dark:text-zinc-100 line-clamp-2">{{ $match->awayTeam->nombre }}</span>
                            @else
                                <div class="h-8 w-12 flex items-center justify-center bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded shadow-sm">
                                    <span class="text-zinc-400 font-bold">?</span>
                                </div>
                                <span class="text-sm font-semibold text-zinc-500 dark:text-zinc-400 italic line-clamp-2">{{ $match->visitante_label ?? 'Por definir' }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Footer Action or Points Display -->
                    <div class="border-t border-zinc-100 dark:border-zinc-800/80 pt-3 mt-4 flex items-center justify-between">
                        <!-- Closing time / Status -->
                        <div>
                            @if(!$isBetsClosed)
                                <span class="text-[11px] text-zinc-400 flex items-center gap-1">
                                    <flux:icon name="clock" class="size-3 text-zinc-400" />
                                    Cierra en: {{ $match->fecha_cierre_apuestas->diffForHumans() }}
                                </span>
                            @else
                                <span class="text-[11px] text-zinc-500 flex items-center gap-1 font-semibold">
                                    <flux:icon name="lock-closed" class="size-3 text-zinc-400" />
                                    Apuestas Cerradas
                                </span>
                            @endif
                        </div>

                        <!-- Points / Save button -->
                        <div>
                            @if(!$isBetsClosed)
                                <flux:button 
                                    size="sm" 
                                    color="emerald" 
                                    variant="filled" 
                                    class="font-semibold cursor-pointer shadow-sm"
                                    wire:click="savePrediction({{ $match->id }})"
                                >
                                    Guardar
                                </flux:button>
                            @else
                                @if($isFinished && $userPrediction)
                                    @if($userPrediction->resultado?->value === 'exacto')
                                        <flux:badge size="sm" color="emerald" class="font-black py-0.5 px-2">
                                            +3 PTS (EXACTO)
                                        </flux:badge>
                                    @elseif($userPrediction->resultado?->value === 'ganador_correcto')
                                        <flux:badge size="sm" color="sky" class="font-bold py-0.5 px-2">
                                            +1 PT (GANADOR)
                                        </flux:badge>
                                    @else
                                        <flux:badge size="sm" color="zinc" class="font-semibold py-0.5 px-2">
                                            0 PTS (FALLADO)
                                        </flux:badge>
                                    @endif
                                @elseif($isFinished && !$userPrediction)
                                    <flux:badge size="sm" color="red" class="font-semibold py-0.5 px-2">
                                        0 PTS (SIN APUESTA)
                                    </flux:badge>
                                @else
                                    <flux:badge size="sm" color="zinc" class="font-semibold">Esperando juego</flux:badge>
                                @endif
                            @endif
                        </div>
                    </div>
                </flux:card>
            @endforeach
        </div>
    @endif
</div>
