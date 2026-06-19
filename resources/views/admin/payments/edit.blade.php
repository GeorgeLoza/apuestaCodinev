<x-layouts::app.sidebar title="Editar Pago">
    <flux:main>
        <div class="max-w-4xl mx-auto p-4 md:p-8 space-y-6">
            <div class="border-b border-zinc-200 dark:border-zinc-700 pb-6">
                <flux:heading size="xl" level="1" class="font-black text-transparent bg-clip-text bg-gradient-to-r from-sky-500 to-indigo-500">
                    Editar Pago #{{ $payment->id }}
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400 mt-1">
                    Actualiza el estado y los datos del pago del usuario.
                </flux:text>
            </div>

            <form method="POST" action="{{ route('admin.payments.update', ['payment' => $payment, 'key' => request()->query('key')]) }}" class="space-y-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 shadow-sm">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Usuario</label>
                        <div class="mt-2 text-zinc-900 dark:text-zinc-100">{{ $payment->user->name }} ({{ $payment->user->codigo }})</div>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Monto</label>
                        <div class="mt-2 font-bold text-zinc-900 dark:text-zinc-100">${{ number_format($payment->monto, 2, ',', '.') }}</div>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <label class="block">
                        <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Estado</span>
                        <select name="estado" class="mt-2 w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white p-3">
                            <option value="pendiente" {{ $payment->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="pagado" {{ $payment->estado === 'pagado' ? 'selected' : '' }}>Pagado</option>
                            <option value="cancelado" {{ $payment->estado === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </label>

                    <label class="block">
                        <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Método</span>
                        <input type="text" name="metodo" value="{{ old('metodo', $payment->metodo) }}" class="mt-2 w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white p-3" placeholder="Ej. Transferencia" />
                    </label>
                </div>

                <label class="block">
                    <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Nota</span>
                    <textarea name="nota" rows="4" class="mt-2 w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white p-3" placeholder="Notas de seguimiento o referencia">{{ old('nota', $payment->nota) }}</textarea>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Fecha de pago</span>
                    <input type="datetime-local" name="pagado_en" value="{{ old('pagado_en', optional($payment->pagado_en)->format('Y-m-d\TH:i')) }}" class="mt-2 w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white p-3" />
                </label>

                <div class="flex items-center justify-between gap-3">
                    <flux:button type="submit" color="emerald" class="font-semibold">Guardar cambios</flux:button>
                    <a href="{{ route('admin.payments.index', ['key' => request()->query('key')]) }}" class="text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">Volver a pagos</a>
                </div>
            </form>
        </div>
    </flux:main>
</x-layouts::app.sidebar>