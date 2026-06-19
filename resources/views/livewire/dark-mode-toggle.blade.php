<div class="flex items-center">
    <button
        @click="toggleDarkMode()"
        class="relative inline-flex items-center justify-center p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors duration-200"
        :aria-label="darkMode ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro'"
    >
        <!-- Sun Icon (Light Mode) -->
        <svg
            x-show="!darkMode"
            class="w-5 h-5 text-amber-500"
            fill="currentColor"
            viewBox="0 0 20 20"
        >
            <path
                fill-rule="evenodd"
                d="M10 2a1 1 0 011 1v2a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.536l1.414 1.414a1 1 0 001.414-1.414l-1.414-1.414a1 1 0 00-1.414 1.414zm2.828-2.828l1.414-1.414a1 1 0 00-1.414-1.414l-1.414 1.414a1 1 0 001.414 1.414zm0-4.243L17.657 6.343a1 1 0 10-1.414-1.414L15.464 7.07a1 1 0 001.414 1.414zM9 4a1 1 0 011 1v2a1 1 0 11-2 0V5a1 1 0 011-1z"
                clip-rule="evenodd"
            />
        </svg>

        <!-- Moon Icon (Dark Mode) -->
        <svg
            x-show="darkMode"
            class="w-5 h-5 text-indigo-400"
            fill="currentColor"
            viewBox="0 0 20 20"
        >
            <path
                d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"
            />
        </svg>
    </button>
</div>

<script>
    function initDarkMode() {
        // Recuperar preferencia de localStorage
        const darkMode = localStorage.getItem('darkMode') === 'true' ||
                        (!('darkMode' in localStorage) &&
                         window.matchMedia('(prefers-color-scheme: dark)').matches);

        // Aplicar la clase al documento
        if (darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        // Exponer función global para toggle
        window.toggleDarkMode = function() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', isDark.toString());
        };

        // Sincronizar con localStorage si cambia desde otra pestaña
        window.addEventListener('storage', (e) => {
            if (e.key === 'darkMode') {
                if (e.newValue === 'true') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
        });
    }

    // Inicializar inmediatamente
    initDarkMode();

    // Re-inicializar cuando Livewire actualiza
    document.addEventListener('livewire:navigated', () => {
        initDarkMode();
    });
</script>
