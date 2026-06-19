<x-layouts::app.sidebar title="Nuevo Pago">
    <flux:main>
        <div class="max-w-4xl mx-auto p-4 md:p-8 space-y-6">
            <div class="border-b border-zinc-200 dark:border-zinc-700 pb-6">
                <flux:heading size="xl" level="1" class="font-black text-transparent bg-clip-text bg-gradient-to-r from-sky-500 to-indigo-500">
                    Crear pago
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400 mt-1">
                    Registra un pago manualmente para un pronóstico.
                </flux:text>
            </div>

            <form method="POST" action="{{ route('admin.payments.store', ['key' => request()->query('key')]) }}" class="space-y-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 shadow-sm">
                @csrf

                <div class="grid gap-4 md:grid-cols-2">
                    <label class="block">
                        <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Usuario</span>
                        <select name="user_id" class="mt-2 w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white p-3">
                            <option value="">Selecciona un usuario</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->codigo }})</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="block">
                        <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Pronóstico</span>
                        <select name="pronostico_id" class="mt-2 w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white p-3">
                            <option value="">Selecciona un pronóstico</option>
                            @foreach($predictions as $prediction)
                                <option value="{{ $prediction->id }}" {{ old('pronostico_id') == $prediction->id ? 'selected' : '' }}>
                                    #{{ $prediction->id }} - {{ $prediction->match->homeTeam?->nombre ?? $prediction->match->local_label ?? 'Local' }} vs {{ $prediction->match->awayTeam?->nombre ?? $prediction->match->visitante_label ?? 'Visitante' }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <label class="block">
                        <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Monto</span>
                        <input type="number" name="monto" step="0.01" min="0" value="{{ old('monto') }}" class="mt-2 w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white p-3" placeholder="0.00" />
                    </label>

                    <label class="block">
                        <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Estado</span>
                        <select name="estado" class="mt-2 w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white p-3">
                            <option value="pendiente" {{ old('estado') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="pagado" {{ old('estado') === 'pagado' ? 'selected' : '' }}>Pagado</option>
                            <option value="cancelado" {{ old('estado') === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </label>
                </div>

                <label class="block">
                    <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Método</span>
                    <input type="text" name="metodo" value="{{ old('metodo') }}" class="mt-2 w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white p-3" placeholder="Ej. Transferencia" />
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Nota</span>
                    <textarea name="nota" rows="4" class="mt-2 w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white p-3" placeholder="Notas de seguimiento o referencia">{{ old('nota') }}</textarea>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Fecha de pago</span>
                    <input type="datetime-local" name="pagado_en" value="{{ old('pagado_en') }}" class="mt-2 w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white p-3" />
                </label>

                <div class="flex items-center justify-between gap-3">
                    <flux:button type="submit" color="emerald" class="font-semibold">Crear pago</flux:button>
                    <a href="{{ route('admin.payments.index', ['key' => request()->query('key')]) }}" class="text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">Volver a pagos</a>
                </div>
            </form>
        </div>
    </flux:main>
</x-layouts::app.sidebar>
