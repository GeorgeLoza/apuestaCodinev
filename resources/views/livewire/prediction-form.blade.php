<form wire:submit.prevent="save" class="space-y-4">
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg">
        <!-- Home Team -->
        <div class="flex items-center space-x-2 flex-1">
            @if($match->homeTeam)
                <img src="{{ $match->homeTeam->getFlagUrl() }}" alt="{{ $match->homeTeam->nombre }}" class="h-6 w-9 object-cover rounded border border-zinc-200 dark:border-zinc-700 shadow-sm">
                <span class="font-bold text-sm text-zinc-800 dark:text-zinc-200">{{ $match->homeTeam->nombre }}</span>
            @else
                <span class="text-sm italic text-zinc-500 dark:text-zinc-400">{{ $match->local_label ?? 'Por definir' }}</span>
            @endif
        </div>

        <!-- Score Inputs -->
        <div class="flex items-center space-x-2 bg-white dark:bg-zinc-900 px-3 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700">
            <input 
                type="number" 
                wire:model.live="golesLocal" 
                class="w-14 text-center font-extrabold text-lg bg-transparent text-zinc-900 dark:text-white focus:outline-none" 
                min="0" 
                max="20"
            >
            <span class="font-bold text-zinc-400 dark:text-zinc-500 text-xl">-</span>
            <input 
                type="number" 
                wire:model.live="golesVisitante" 
                class="w-14 text-center font-extrabold text-lg bg-transparent text-zinc-900 dark:text-white focus:outline-none" 
                min="0" 
                max="20"
            >
        </div>

        <!-- Away Team -->
        <div class="flex items-center space-x-2 flex-1 justify-end">
            <span class="font-bold text-sm text-zinc-800 dark:text-zinc-200">{{ $match->awayTeam?->nombre ?? $match->visitante_label ?? 'Por definir' }}</span>
            @if($match->awayTeam)
                <img src="{{ $match->awayTeam->getFlagUrl() }}" alt="{{ $match->awayTeam->nombre }}" class="h-6 w-9 object-cover rounded border border-zinc-200 dark:border-zinc-700 shadow-sm">
            @endif
        </div>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
            <ul class="text-sm text-red-600 dark:text-red-400 space-y-1">
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Save Button -->
    <div class="flex justify-end gap-2">
        <flux:button type="submit" size="sm" color="emerald" class="cursor-pointer font-semibold" icon-trailing="check">
            Guardar Pronóstico
        </flux:button>
    </div>
</form>
