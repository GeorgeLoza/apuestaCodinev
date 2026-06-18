<div class="max-w-7xl mx-auto p-4">

    <h1 class="text-3xl font-bold mb-6">
        Mundial 2026
    </h1>

    <div class="grid gap-4">

        @foreach($matches as $match)

            <div
                class="bg-white rounded-xl shadow p-4"
            >
                <div class="flex justify-between">

                    <div>
                        {{ $match->homeTeam?->nombre ?? $match->local_label }}
                    </div>

                    <div class="font-bold">
                        VS
                    </div>

                    <div>
                        {{ $match->awayTeam?->nombre ?? $match->visitante_label }}
                    </div>

                </div>

                <div class="text-sm text-gray-500 mt-2">
                    {{ $match->fecha_partido }}
                </div>

            </div>

        @endforeach

    </div>

</div>