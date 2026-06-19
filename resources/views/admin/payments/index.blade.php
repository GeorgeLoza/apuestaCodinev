<x-layouts::app.sidebar title="Pagos de Apuestas">
    <flux:main>
        <div class="max-w-7xl mx-auto p-4 md:p-8 space-y-6">
            <div class="border-b border-zinc-200 dark:border-zinc-700 pb-6">
                <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                    <div>
                        <flux:heading size="xl" level="1" class="font-black text-transparent bg-clip-text bg-gradient-to-r from-sky-500 to-indigo-500">
                            Seguimiento de Pagos
                        </flux:heading>
                        <flux:text class="text-zinc-500 dark:text-zinc-400 mt-1">
                            Controla pagos de los usuarios por apuestas y revisa el estado de cada transacción.
                        </flux:text>
                    </div>

                    <div class="flex flex-col items-start gap-3 sm:items-end">
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('admin.payments.create', ['key' => request()->query('key')]) }}" class="inline-flex items-center gap-2 rounded-full bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-500">
                                Nuevo pago
                            </a>
                            <form method="POST" action="{{ route('admin.payments.sync', ['key' => request()->query('key')]) }}" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-2 rounded-full border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-100 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800">
                                    Sincronizar API
                                </button>
                            </form>
                        </div>
                        <span class="text-sm text-zinc-500 dark:text-zinc-400">
                            Última actualización API:
                            {{ $lastSync ? $lastSync->format('d/m/Y H:i') : 'No disponible' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden shadow-sm">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-zinc-50 dark:bg-zinc-800/50 text-xs font-bold text-zinc-500 dark:text-zinc-400 uppercase border-b border-zinc-200 dark:border-zinc-800">
                            <th class="py-4 px-6">ID</th>
                            <th class="py-4 px-6">Usuario</th>
                            <th class="py-4 px-6">Apuesta</th>
                            <th class="py-4 px-6">Monto</th>
                            <th class="py-4 px-6">Método</th>
                            <th class="py-4 px-6">Estado</th>
                            <th class="py-4 px-6">Pagado</th>
                            <th class="py-4 px-6">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition-colors duration-150">
                                <td class="py-4 px-6">{{ $payment->id }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex flex-col gap-1">
                                        <span class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $payment->user->name }}</span>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $payment->user->codigo }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-sm text-zinc-700 dark:text-zinc-200">
                                    {{ $payment->prediction->match->homeTeam?->nombre ?? $payment->prediction->match->local_label ?? 'Local' }}
                                    vs
                                    {{ $payment->prediction->match->awayTeam?->nombre ?? $payment->prediction->match->visitante_label ?? 'Visitante' }}
                                </td>
                                <td class="py-4 px-6 font-bold text-zinc-900 dark:text-white">${{ number_format($payment->monto, 2, ',', '.') }}</td>
                                <td class="py-4 px-6">{{ $payment->metodo ?? 'No especificado' }}</td>
                                <td class="py-4 px-6">
                                    <flux:badge size="sm" color="{{ $payment->estado === 'pagado' ? 'emerald' : ($payment->estado === 'cancelado' ? 'rose' : 'amber') }}" class="font-semibold">
                                        {{ ucfirst($payment->estado) }}
                                    </flux:badge>
                                </td>
                                <td class="py-4 px-6 text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $payment->pagado_en ? $payment->pagado_en->format('d/m/Y H:i') : 'Sin fecha' }}
                                </td>
                                <td class="py-4 px-6">
                                    <a href="{{ route('admin.payments.edit', $payment) }}" class="font-semibold text-sky-600 dark:text-sky-400">Editar</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 px-6 text-center text-zinc-500 dark:text-zinc-400">
                                    No hay pagos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex justify-center">
                {{ $payments->links() }}
            </div>
        </div>
    </flux:main>
</x-layouts::app.sidebar>