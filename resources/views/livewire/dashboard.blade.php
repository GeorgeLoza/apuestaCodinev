<div class="max-w-7xl mx-auto p-4 md:p-8 space-y-8">
    
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden bg-gradient-to-r from-emerald-500 to-teal-600 rounded-3xl p-6 md:p-8 text-white shadow-md border border-emerald-400/20">
        <!-- Decorative background shapes -->
        <div class="absolute right-0 top-0 translate-x-12 -translate-y-12 opacity-10 blur-xl size-64 bg-white rounded-full"></div>
        <div class="absolute right-12 bottom-0 translate-y-12 opacity-20 size-48 bg-teal-300 rounded-full"></div>
        
        <div class="relative z-10 space-y-2 max-w-2xl">
            <span class="text-xs font-bold uppercase tracking-widest bg-white/20 px-2.5 py-1 rounded-full text-emerald-100">
                Mundial FIFA 2026
            </span>
            <flux:heading size="xl" class="text-white font-black leading-tight">
                ¡Bienvenido a la Polla Mundialista, {{ Auth::user()->name }}!
            </flux:heading>
            <flux:text class="text-emerald-100 text-sm md:text-base">
                El gran torneo está en marcha. Realiza tus pronósticos antes de cada partido, acumula puntos y sube en la tabla de posiciones. ¡Que gane el mejor!
            </flux:text>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid gap-4 md:grid-cols-3">
        <!-- Total Points -->
        <flux:card class="border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 rounded-2xl p-6 shadow-xs flex items-center space-x-4">
            <div class="p-3 bg-emerald-500/10 dark:bg-emerald-500/20 rounded-xl text-emerald-500">
                <flux:icon name="academic-cap" class="size-8 text-emerald-500 dark:text-emerald-400" />
            </div>
            <div>
                <flux:heading size="sm" class="text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-bold">Puntos Totales</flux:heading>
                <div class="text-3xl font-black text-zinc-900 dark:text-white mt-1">{{ $totalPoints }}</div>
            </div>
        </flux:card>

        <!-- Leaderboard Position -->
        <flux:card class="border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 rounded-2xl p-6 shadow-xs flex items-center space-x-4">
            <div class="p-3 bg-amber-500/10 dark:bg-amber-500/20 rounded-xl text-amber-500">
                <flux:icon name="trophy" class="size-8 text-amber-500 dark:text-amber-400" />
            </div>
            <div>
                <flux:heading size="sm" class="text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-bold">Posición en Ranking</flux:heading>
                <div class="text-3xl font-black text-zinc-900 dark:text-white mt-1">#{{ $rankingPosition }}</div>
            </div>
        </flux:card>

        <!-- Predictions count -->
        <flux:card class="border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 rounded-2xl p-6 shadow-xs flex items-center space-x-4">
            <div class="p-3 bg-sky-500/10 dark:bg-sky-500/20 rounded-xl text-sky-500">
                <flux:icon name="calendar" class="size-8 text-sky-500 dark:text-sky-400" />
            </div>
            <div class="flex-grow">
                <flux:heading size="sm" class="text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-bold">Pronósticos Guardados</flux:heading>
                <div class="flex items-baseline space-x-1.5 mt-1">
                    <span class="text-3xl font-black text-zinc-900 dark:text-white">{{ $predictionsCount }}</span>
                    <span class="text-xs text-zinc-400 font-semibold">de {{ $totalMatches }} partidos</span>
                </div>
            </div>
        </flux:card>
    </div>

    <!-- Main Layout Grid -->
    <div class="grid gap-8 lg:grid-cols-12">
        
        <!-- Left Side: Match Prediction & Results -->
        <div class="lg:col-span-8 space-y-8">
            
            <!-- Quick Predictions -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <flux:heading size="lg" class="font-black text-zinc-800 dark:text-white flex items-center gap-2">
                        <flux:icon name="fire" class="size-5 text-amber-500" />
                        Próximos Partidos por Pronosticar
                    </flux:heading>
                    <flux:button href="{{ route('matches.index') }}" variant="ghost" size="sm" class="font-semibold cursor-pointer" wire:navigate>
                        Ver todos
                    </flux:button>
                </div>

                @if($upcomingMatches->isEmpty())
                    <div class="p-8 bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl text-center">
                        <flux:icon name="check-circle" class="size-10 text-emerald-500 mx-auto mb-2" />
                        <flux:heading size="md">¡Estás al día!</flux:heading>
                        <flux:text class="text-xs mt-1">No hay partidos próximos pendientes de pronóstico.</flux:text>
                    </div>
                @else
                    <div class="grid gap-4 md:grid-cols-2">
                        @foreach($upcomingMatches as $match)
                            <flux:card class="border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 rounded-2xl p-4 flex flex-col justify-between space-y-4 hover:shadow-xs transition-shadow duration-200">
                                <div class="flex items-center justify-between text-[11px] font-bold text-zinc-400 uppercase border-b border-zinc-100 dark:border-zinc-800/80 pb-2">
                                    <span>{{ $match->tipo }}</span>
                                    <span>Cierra {{ $match->fecha_cierre_apuestas->diffForHumans() }}</span>
                                </div>

                                <div class="grid grid-cols-12 gap-1 items-center py-1">
                                    <!-- Home -->
                                    <div class="col-span-4 flex flex-col items-center text-center">
                                        @if($match->homeTeam)
                                            <img src="{{ $match->homeTeam->getFlagUrl() }}" alt="{{ $match->homeTeam->nombre }}" class="h-6 w-10 object-cover rounded border border-zinc-200 dark:border-zinc-700 mb-1.5">
                                            <span class="font-bold text-xs text-zinc-800 dark:text-zinc-200 line-clamp-1">{{ $match->homeTeam->nombre }}</span>
                                        @else
                                            <div class="h-6 w-10 bg-zinc-100 dark:bg-zinc-800 border rounded flex items-center justify-center mb-1.5"><span class="text-xs text-zinc-400">?</span></div>
                                            <span class="font-bold text-xs text-zinc-500 italic line-clamp-1">{{ $match->local_label ?? 'Por definir' }}</span>
                                        @endif
                                    </div>

                                    <!-- Score Input -->
                                    <div class="col-span-4 flex items-center justify-center space-x-1">
                                        <input 
                                            type="number" 
                                            wire:model="quickPredictions.{{ $match->id }}.goles_local"
                                            class="w-10 text-center font-extrabold text-sm bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg py-1 focus:ring-1 focus:ring-emerald-500 focus:outline-hidden"
                                            min="0"
                                            max="20"
                                        >
                                        <span class="font-bold text-zinc-400">-</span>
                                        <input 
                                            type="number" 
                                            wire:model="quickPredictions.{{ $match->id }}.goles_visitante"
                                            class="w-10 text-center font-extrabold text-sm bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg py-1 focus:ring-1 focus:ring-emerald-500 focus:outline-hidden"
                                            min="0"
                                            max="20"
                                        >
                                    </div>

                                    <!-- Away -->
                                    <div class="col-span-4 flex flex-col items-center text-center">
                                        @if($match->awayTeam)
                                            <img src="{{ $match->awayTeam->getFlagUrl() }}" alt="{{ $match->awayTeam->nombre }}" class="h-6 w-10 object-cover rounded border border-zinc-200 dark:border-zinc-700 mb-1.5">
                                            <span class="font-bold text-xs text-zinc-800 dark:text-zinc-200 line-clamp-1">{{ $match->awayTeam->nombre }}</span>
                                        @else
                                            <div class="h-6 w-10 bg-zinc-100 dark:bg-zinc-800 border rounded flex items-center justify-center mb-1.5"><span class="text-xs text-zinc-400">?</span></div>
                                            <span class="font-bold text-xs text-zinc-500 italic line-clamp-1">{{ $match->visitante_label ?? 'Por definir' }}</span>
                                        @endif
                                    </div>
                                </div>

                                <flux:button 
                                    size="sm" 
                                    color="emerald" 
                                    class="w-full font-semibold cursor-pointer"
                                    wire:click="saveQuickPrediction({{ $match->id }})"
                                >
                                    Guardar Pronóstico
                                </flux:button>
                            </flux:card>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Recent Results -->
            <div class="space-y-4">
                <flux:heading size="lg" class="font-black text-zinc-800 dark:text-white flex items-center gap-2">
                    <flux:icon name="check-circle" class="size-5 text-emerald-500" />
                    Tus Resultados Recientes
                </flux:heading>

                @if($recentResults->isEmpty())
                    <div class="p-8 bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl text-center text-zinc-400">
                        Aún no hay partidos finalizados en la base de datos.
                    </div>
                @else
                    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden shadow-xs divide-y divide-zinc-100 dark:divide-zinc-800">
                        @foreach($recentResults as $match)
                            @php 
                                $userPred = $match->predictions->first();
                            @endphp
                            <div class="p-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex items-center space-x-4">
                                    <!-- Date & Info -->
                                    <div class="text-center min-w-[70px] border-r border-zinc-100 dark:border-zinc-800 pr-4">
                                        <span class="text-xs text-zinc-400 uppercase font-bold block">{{ $match->fecha_partido->format('d M') }}</span>
                                        <span class="text-[10px] text-zinc-500 block">{{ $match->fecha_partido->format('H:i') }}</span>
                                    </div>

                                    <!-- Teams Comparison -->
                                    <div class="flex items-center space-x-3">
                                        <div class="flex items-center space-x-1.5">
                                            @if($match->homeTeam)
                                                <img src="{{ $match->homeTeam->getFlagUrl() }}" alt="{{ $match->homeTeam->nombre }}" class="h-4 w-6 object-cover rounded shadow-2xs border border-zinc-200 dark:border-zinc-700">
                                                <span class="font-bold text-xs text-zinc-800 dark:text-zinc-200">{{ $match->homeTeam->nombre }}</span>
                                            @else
                                                <span class="font-bold text-xs text-zinc-500 italic">{{ $match->local_label ?? 'Por definir' }}</span>
                                            @endif
                                        </div>
                                        <span class="font-black text-sm text-zinc-900 dark:text-white">
                                            {{ $match->goles_local }} - {{ $match->goles_visitante }}
                                        </span>
                                        <div class="flex items-center space-x-1.5">
                                            <span class="font-bold text-xs text-zinc-800 dark:text-zinc-200">{{ $match->awayTeam?->nombre ?? $match->visitante_label ?? 'Por definir' }}</span>
                                            @if($match->awayTeam)
                                                <img src="{{ $match->awayTeam->getFlagUrl() }}" alt="{{ $match->awayTeam->nombre }}" class="h-4 w-6 object-cover rounded shadow-2xs border border-zinc-200 dark:border-zinc-700">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- User Prediction & Points -->
                                <div class="flex items-center justify-between md:justify-end gap-6 border-t md:border-t-0 border-zinc-100 pt-2 md:pt-0">
                                    <div class="text-left md:text-right">
                                        <span class="text-[10px] uppercase font-bold text-zinc-400 block">Tu pronóstico</span>
                                        <span class="font-bold text-xs text-zinc-600 dark:text-zinc-400">
                                            {{ $userPred ? "{$userPred->goles_local} - {$userPred->goles_visitante}" : 'Sin apuesta' }}
                                        </span>
                                    </div>

                                    <div>
                                        @if($userPred)
                                            @if($userPred->resultado?->value === 'exacto')
                                                <flux:badge size="sm" color="emerald" class="font-black py-0.5 px-2">
                                                    +3 PTS
                                                </flux:badge>
                                            @elseif($userPred->resultado?->value === 'ganador_correcto')
                                                <flux:badge size="sm" color="sky" class="font-bold py-0.5 px-2">
                                                    +1 PT
                                                </flux:badge>
                                            @else
                                                <flux:badge size="sm" color="zinc" class="font-semibold py-0.5 px-2">
                                                    0 PTS
                                                </flux:badge>
                                            @endif
                                        @else
                                            <flux:badge size="sm" color="red" class="font-semibold py-0.5 px-2">
                                                0 PTS
                                            </flux:badge>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>

        <!-- Right Side: Mini Leaderboard -->
        <div class="lg:col-span-4 space-y-6">
            
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl p-6 shadow-xs space-y-6">
                <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800/80 pb-4">
                    <flux:heading size="md" class="font-black text-zinc-800 dark:text-white flex items-center gap-2">
                        <flux:icon name="trophy" class="size-5 text-amber-500" />
                        Top 5 Leaderboard
                    </flux:heading>
                    <flux:icon name="arrow-right" class="size-4 text-zinc-400" />
                </div>

                <div class="space-y-4">
                    @foreach($leaderboard as $index => $user)
                        @php 
                            $isCurrentUser = $user->id === Auth::id();
                            $pos = $index + 1;
                        @endphp
                        <div class="flex items-center justify-between p-2 rounded-xl transition-colors duration-150 {{ $isCurrentUser ? 'bg-emerald-500/[0.06] border border-emerald-500/20' : '' }}">
                            <div class="flex items-center space-x-3">
                                <!-- Position Badge -->
                                <div class="w-6 text-center">
                                    @if($pos === 1)
                                        <span class="text-amber-500 text-sm font-black">🥇</span>
                                    @elseif($pos === 2)
                                        <span class="text-zinc-400 text-sm font-black">🥈</span>
                                    @elseif($pos === 3)
                                        <span class="text-amber-700 text-sm font-black">🥉</span>
                                    @else
                                        <span class="text-zinc-400 text-xs font-bold">{{ $pos }}</span>
                                    @endif
                                </div>

                                <!-- Avatar & Name -->
                                <flux:avatar :name="$user->name" :initials="$user->initials()" size="xs" />
                                <span class="font-bold text-xs text-zinc-800 dark:text-zinc-200 truncate max-w-[120px] md:max-w-none">
                                    {{ $user->name }}
                                </span>
                            </div>

                            <span class="font-black text-xs text-zinc-900 dark:text-white bg-zinc-50 dark:bg-zinc-800/80 border border-zinc-200 dark:border-zinc-800 px-2 py-0.5 rounded-md">
                                {{ $user->total_points }} pts
                            </span>
                        </div>
                    @endforeach
                </div>

                <flux:button href="{{ route('ranking.index') }}" color="zinc" variant="filled" class="w-full font-semibold cursor-pointer" wire:navigate>
                    Ver Tabla Completa
                </flux:button>
            </div>

        </div>

    </div>

</div>