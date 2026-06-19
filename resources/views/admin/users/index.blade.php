<x-layouts::app.sidebar title="Administración de Usuarios">
    <flux:main>
        <div class="max-w-7xl mx-auto p-4 md:p-8 space-y-8">
            <!-- Header -->
            <div class="border-b border-zinc-200 dark:border-zinc-700 pb-6">
                <flux:heading size="xl" level="1" class="font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-500">
                    Administración de Usuarios
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400 mt-1">
                    Gestión de usuarios registrados en la plataforma.
                </flux:text>
            </div>

            <!-- Users Table -->
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden shadow-sm">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-zinc-50 dark:bg-zinc-800/50 text-xs font-bold text-zinc-500 dark:text-zinc-400 uppercase border-b border-zinc-200 dark:border-zinc-800">
                            <th class="py-4 px-6">ID</th>
                            <th class="py-4 px-6">Nombre</th>
                            <th class="py-4 px-6">Código</th>
                            <th class="py-4 px-6 text-right">Registrado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @forelse($users as $user)
                            <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition-colors duration-150">
                                <td class="py-4 px-6">
                                    <flux:badge size="sm" color="zinc" class="font-mono font-bold">
                                        {{ $user->id }}
                                    </flux:badge>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <flux:avatar :name="$user->name" :initials="$user->initials()" size="sm" />
                                        <span class="font-semibold text-zinc-800 dark:text-zinc-200">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <flux:badge size="sm" color="emerald" variant="outline" class="font-mono font-bold">
                                        {{ $user->codigo }}
                                    </flux:badge>
                                </td>
                                <td class="py-4 px-6 text-right text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $user->created_at->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 px-6 text-center">
                                    <flux:icon name="users" class="size-10 text-zinc-400 mx-auto mb-3" />
                                    <flux:heading size="md" class="text-zinc-500 dark:text-zinc-400">No hay usuarios</flux:heading>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="flex justify-center">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </flux:main>
</x-layouts::app.sidebar>
