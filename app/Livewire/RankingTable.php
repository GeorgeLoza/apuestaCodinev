<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Tabla de Posiciones')]
class RankingTable extends Component
{
    public function render()
    {
        $users = User::query()
            ->withSum('predictions', 'puntos')
            ->withCount([
                'predictions as total_predictions',
                'predictions as exact_hits' => function ($query) {
                    $query->where('resultado', 'exacto');
                },
                'predictions as winner_hits' => function ($query) {
                    $query->where('resultado', 'ganador_correcto');
                }
            ])
            ->get()
            ->map(function ($user) {
                $user->total_points = (int) ($user->predictions_sum_puntos ?? 0);
                return $user;
            })
            ->sortByDesc('total_points')
            ->values();

        // Separate top 3 for the podium
        $top3 = $users->take(3);
        $remainingUsers = $users->slice(3);

        return view('livewire.ranking-table', [
            'users' => $users,
            'top3' => $top3,
            'remainingUsers' => $remainingUsers,
        ]);
    }
}
