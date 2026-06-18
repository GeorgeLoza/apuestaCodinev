<form wire:submit.prevent="save" class="space-y-4">
    <div class="flex items-center justify-between space-x-4">
        <div class="flex items-center space-x-2">
            @if($match->homeTeam)
                <img src="{{ $match->homeTeam->getFlagUrl() }}" alt="{{ $match->homeTeam->nombre }}" class="h-6 w-9 object-cover rounded border border-zinc-200">
                <span class="font-bold text-sm">{{ $match->homeTeam->nombre }}</span>
            @else
                <span class="text-sm italic text-zinc-500">{{ $match->local_label ?? 'Por definir' }}</span>
            @endif
        </div>
        <div class="flex items-center space-x-2">
            <input type="number" wire:model="golesLocal" class="w-12 text-center font-bold bg-zinc-50 dark:bg-zinc-800 border dark:border-zinc-700 rounded py-1 focus:ring-2 focus:ring-emerald-500 focus:outline-hidden" min="0" max="20">
            <span class="font-bold text-zinc-400">-</span>
            <input type="number" wire:model="golesVisitante" class="w-12 text-center font-bold bg-zinc-50 dark:bg-zinc-800 border dark:border-zinc-700 rounded py-1 focus:ring-2 focus:ring-emerald-500 focus:outline-hidden" min="0" max="20">
        </div>
        <div class="flex items-center space-x-2 justify-end">
            <span class="font-bold text-sm">{{ $match->awayTeam?->nombre ?? $match->visitante_label ?? 'Por definir' }}</span>
            @if($match->awayTeam)
                <img src="{{ $match->awayTeam->getFlagUrl() }}" alt="{{ $match->awayTeam->nombre }}" class="h-6 w-9 object-cover rounded border border-zinc-200">
            @endif
        </div>
    </div>
    <div class="flex justify-end">
        <flux:button type="submit" size="sm" color="emerald" class="cursor-pointer">Guardar</flux:button>
    </div>
</form>
