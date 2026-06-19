<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="darkMode()" :class="{ 'dark': darkMode }">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Plataforma')" class="grid">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Inicio') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="calendar" :href="route('matches.index')" :current="request()->routeIs('matches.index')" wire:navigate>
                        {{ __('Partidos') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="chart-bar" :href="route('ranking.index')" :current="request()->routeIs('ranking.index')" wire:navigate>
                        {{ __('Posiciones') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group :heading="__('Administración')" class="grid">
                    <flux:sidebar.item icon="users" :href="route('admin.users', ['key' => request()->query('key')])" :current="request()->routeIs('admin.users')" wire:navigate>
                        {{ __('Usuarios') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="credit-card" :href="route('admin.payments.index', ['key' => request()->query('key')])" :current="request()->routeIs('admin.payments.*')" wire:navigate>
                        {{ __('Pagos') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <!-- Dark Mode Toggle -->
            <div class="p-3 border-t border-zinc-200 dark:border-zinc-700">
                <button
                    @click="toggleDarkMode()"
                    class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-800 transition-colors duration-200 text-zinc-700 dark:text-zinc-300"
                >
                    <svg x-show="!darkMode" class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v2a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.536l1.414 1.414a1 1 0 001.414-1.414l-1.414-1.414a1 1 0 00-1.414 1.414zm2.828-2.828l1.414-1.414a1 1 0 00-1.414-1.414l-1.414 1.414a1 1 0 001.414 1.414zm0-4.243L17.657 6.343a1 1 0 10-1.414-1.414L15.464 7.07a1 1 0 001.414 1.414zM9 4a1 1 0 011 1v2a1 1 0 11-2 0V5a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    <svg x-show="darkMode" class="w-5 h-5 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                    </svg>
                    <span class="text-sm font-semibold" x-text="darkMode ? 'Modo Oscuro' : 'Modo Claro'"></span>
                </button>
            </div>

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->codigo }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts

        <script>
            function darkMode() {
                return {
                    darkMode: localStorage.getItem('darkMode') === 'true' ||
                             (!('darkMode' in localStorage) &&
                              window.matchMedia('(prefers-color-scheme: dark)').matches),
                    toggleDarkMode() {
                        this.darkMode = !this.darkMode;
                        localStorage.setItem('darkMode', this.darkMode.toString());
                        document.documentElement.classList.toggle('dark', this.darkMode);
                    },
                    init() {
                        // Aplicar la clase al cargar
                        if (this.darkMode) {
                            document.documentElement.classList.add('dark');
                        }
                        // Sincronizar con localStorage desde otras pestañas
                        window.addEventListener('storage', (e) => {
                            if (e.key === 'darkMode') {
                                this.darkMode = e.newValue === 'true';
                                document.documentElement.classList.toggle('dark', this.darkMode);
                            }
                        });
                    }
                }
            }
        </script>
    </body>
</html>
