<div class="max-w-5xl mx-auto p-4 md:p-8 space-y-10">
    <!-- Header -->
    <div class="border-b border-zinc-200 dark:border-zinc-700 pb-6">
        <flux:heading size="xl" level="1" class="font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-500">
            Tabla de Posiciones
        </flux:heading>
        <flux:text class="text-zinc-500 dark:text-zinc-400 mt-1">
            Compite con otros usuarios. Los puntos se calculan automáticamente tras cada partido finalizado.
        </flux:text>
    </div>

    <!-- Points Scoring Guide Accordion/Alert -->
    <div class="p-4 bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl flex items-start gap-3 text-sm text-zinc-600 dark:text-zinc-400">
        <flux:icon name="information-circle" class="size-5 text-emerald-500 shrink-0 mt-0.5" />
        <div>
            <span class="font-bold text-zinc-800 dark:text-white">Reglas de puntuación:</span>
            <ul class="list-disc list-inside mt-1 space-y-1">
                <li><strong class="text-emerald-600 dark:text-emerald-400">2 puntos</strong> por acertar el resultado exacto (ej. pronosticaste 2-1 y el partido terminó 2-1).</li>
                <li><strong class="text-sky-600 dark:text-sky-400">1 punto</strong> por acertar el ganador o empate pero no el marcador exacto (ej. pronosticaste 2-0 y terminó 1-0).</li>
                <li><strong class="text-zinc-600 dark:text-zinc-400">0 puntos</strong> si no acertaste el resultado ni el ganador.</li>
            </ul>
        </div>
    </div>

    @if($users->isEmpty())
        <div class="text-center py-12">
            <flux:text>No hay usuarios registrados en el torneo.</flux:text>
        </div>
    @else
        <!-- Podium (Top 3) -->
        <div class="grid grid-cols-3 gap-4 md:gap-8 max-w-3xl mx-auto items-end pt-10 pb-4">
            
            <!-- 2nd Place -->
            <div class="flex flex-col items-center">
                @if($top3->has(1))
                    @php $second = $top3->get(1); @endphp
                    <div class="flex flex-col items-center space-y-2 mb-3">
                        <div class="relative">
                            <flux:avatar 
                                :name="$second->name" 
                                :initials="$second->initials()" 
                                size="lg" 
                                class="ring-4 ring-zinc-300 dark:ring-zinc-600 bg-gradient-to-tr from-zinc-200 to-zinc-400 text-zinc-800"
                            />
                            <div class="absolute -top-3 -right-2 bg-zinc-400 text-white rounded-full size-6 flex items-center justify-center text-xs font-black shadow border border-white dark:border-zinc-800">
                                2
                            </div>
                        </div>
                        <span class="font-bold text-sm text-zinc-800 dark:text-zinc-200 text-center line-clamp-1 max-w-[100px] md:max-w-none">
                            {{ $second->name }}
                        </span>
                        <flux:badge size="sm" color="zinc" class="font-bold">
                            {{ $second->total_points }} PTS
                        </flux:badge>
                    </div>
                    <!-- Pedestal -->
                    <div class="w-full bg-gradient-to-t from-zinc-200 to-zinc-100 dark:from-zinc-800 dark:to-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-t-2xl h-24 flex items-center justify-center shadow-xs">
                        <span class="text-2xl font-black text-zinc-400 dark:text-zinc-600">2ND</span>
                    </div>
                @else
                    <div class="h-24"></div>
                @endif
            </div>

            <!-- 1st Place (Winner) -->
            <div class="flex flex-col items-center">
                @if($top3->has(0))
                    @php $first = $top3->get(0); @endphp
                    <div class="flex flex-col items-center space-y-2 mb-3">
                        <div class="relative">
                            <!-- Crown Icon -->
                            <flux:icon name="academic-cap" class="size-8 text-amber-500 absolute -top-7 left-1/2 -translate-x-1/2 rotate-12 drop-shadow-md animate-bounce" />
                            <flux:avatar 
                                :name="$first->name" 
                                :initials="$first->initials()" 
                                size="xl" 
                                class="ring-4 ring-amber-400 bg-gradient-to-tr from-yellow-300 to-amber-500 text-white shadow-lg shadow-amber-400/20"
                            />
                            <div class="absolute -top-3 -right-2 bg-amber-500 text-white rounded-full size-6 flex items-center justify-center text-xs font-black shadow border border-white dark:border-zinc-800">
                                1
                            </div>
                        </div>
                        <span class="font-extrabold text-base text-zinc-900 dark:text-white text-center line-clamp-1 max-w-[100px] md:max-w-none">
                            {{ $first->name }}
                        </span>
                        <flux:badge size="md" color="amber" class="font-extrabold px-2.5 py-0.5">
                            {{ $first->total_points }} PTS
                        </flux:badge>
                    </div>
                    <!-- Pedestal -->
                    <div class="w-full bg-gradient-to-t from-amber-100 to-amber-50/50 dark:from-amber-950/20 dark:to-amber-900/10 border-t-2 border-x border-amber-300 dark:border-amber-900/60 rounded-t-2xl h-36 flex items-center justify-center shadow-md">
                        <span class="text-3xl font-black text-amber-500/80">1ST</span>
                    </div>
                @else
                    <div class="h-36"></div>
                @endif
            </div>

            <!-- 3rd Place -->
            <div class="flex flex-col items-center">
                @if($top3->has(2))
                    @php $third = $top3->get(2); @endphp
                    <div class="flex flex-col items-center space-y-2 mb-3">
                        <div class="relative">
                            <flux:avatar 
                                :name="$third->name" 
                                :initials="$third->initials()" 
                                size="lg" 
                                class="ring-4 ring-amber-700/60 dark:ring-amber-700/80 bg-gradient-to-tr from-amber-600 to-amber-800 text-white"
                            />
                            <div class="absolute -top-3 -right-2 bg-amber-700 text-white rounded-full size-6 flex items-center justify-center text-xs font-black shadow border border-white dark:border-zinc-800">
                                3
                            </div>
                        </div>
                        <span class="font-bold text-sm text-zinc-800 dark:text-zinc-200 text-center line-clamp-1 max-w-[100px] md:max-w-none">
                            {{ $third->name }}
                        </span>
                        <flux:badge size="sm" color="zinc" class="font-bold">
                            {{ $third->total_points }} PTS
                        </flux:badge>
                    </div>
                    <!-- Pedestal -->
                    <div class="w-full bg-gradient-to-t from-orange-100 to-orange-50/50 dark:from-amber-950/10 dark:to-zinc-900 border border-orange-200 dark:border-zinc-800 rounded-t-2xl h-20 flex items-center justify-center shadow-xs">
                        <span class="text-xl font-black text-amber-700/80">3RD</span>
                    </div>
                @else
                    <div class="h-20"></div>
                @endif
            </div>
        </div>

        <!-- Leaderboard Table -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50 text-xs font-bold text-zinc-500 dark:text-zinc-400 uppercase border-b border-zinc-200 dark:border-zinc-800">
                        <th class="py-4 px-6 text-center w-16">Pos</th>
                        <th class="py-4 px-6">Usuario</th>
                        <th class="py-4 px-6 text-center">Pronósticos</th>
                        <th class="py-4 px-6 text-center">Exactos (+3)</th>
                        <th class="py-4 px-6 text-center">Ganadores (+1)</th>
                        <th class="py-4 px-6 text-right pr-8">Puntos Totales</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @foreach($users as $index => $user)
                        @php 
                            $isCurrentUser = $user->id === Auth::id();
                            $position = $index + 1;
                        @endphp
                        <tr class="transition-colors duration-150 {{ $isCurrentUser ? 'bg-emerald-500/[0.06] hover:bg-emerald-500/[0.1] border-l-4 border-l-emerald-500' : 'hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30' }}">
                            <!-- Position -->
                            <td class="py-4 px-6 text-center">
                                @if($position === 1)
                                    <span class="inline-flex size-6 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-950 text-amber-600 dark:text-amber-400 font-extrabold text-sm shadow-xs">1</span>
                                @elseif($position === 2)
                                    <span class="inline-flex size-6 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 font-extrabold text-sm shadow-xs">2</span>
                                @elseif($position === 3)
                                    <span class="inline-flex size-6 items-center justify-center rounded-full bg-amber-500/10 dark:bg-amber-700/20 text-amber-700 dark:text-amber-600 font-extrabold text-sm shadow-xs">3</span>
                                @else
                                    <span class="text-zinc-500 dark:text-zinc-400 text-sm font-semibold">{{ $position }}</span>
                                @endif
                            </td>

                            <!-- User Info -->
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <flux:avatar :name="$user->name" :initials="$user->initials()" size="sm" />
                                    <div class="flex flex-col">
                                        <span class="font-bold text-zinc-800 dark:text-zinc-200 flex items-center gap-1.5">
                                            {{ $user->name }}
                                            @if($isCurrentUser)
                                                <flux:badge size="sm" color="emerald" variant="outline" class="font-bold py-0.5">Tú</flux:badge>
                                            @endif
                                        </span>
                                        <span class="text-xs text-zinc-400">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Total Predictions -->
                            <td class="py-4 px-6 text-center text-zinc-600 dark:text-zinc-400 text-sm font-medium">
                                {{ $user->total_predictions }}
                            </td>

                            <!-- Exact Hits -->
                            <td class="py-4 px-6 text-center text-emerald-600 dark:text-emerald-400 text-sm font-bold">
                                {{ $user->exact_hits }}
                            </td>

                            <!-- Winner Hits -->
                            <td class="py-4 px-6 text-center text-sky-600 dark:text-sky-400 text-sm font-semibold">
                                {{ $user->winner_hits }}
                            </td>

                            <!-- Total Points -->
                            <td class="py-4 px-6 text-right pr-8">
                                <span class="text-base font-black text-zinc-900 dark:text-white">
                                    {{ $user->total_points }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
