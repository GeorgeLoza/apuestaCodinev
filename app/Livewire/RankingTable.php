<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Tabla de Posiciones')]
class RankingTable extends Component
{
    public function render()
    {
        $isAdmin = Request::session()->get('admin_access', false)
            || Request::query('key') === env('ADMIN_ACCESS_KEY');

        $allUsers = User::query()
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

        $top3 = $allUsers->take(3);
        $currentUser = Auth::user();
        $currentPosition = null;
        $currentUserRecord = null;

        if ($currentUser) {
            $currentPosition = $allUsers->search(fn ($user) => $user->id === $currentUser->id);
            if ($currentPosition !== false) {
                $currentPosition += 1;
                $currentUserRecord = $allUsers->firstWhere('id', $currentUser->id);
            }
        }

        if ($isAdmin) {
            $users = $allUsers;
            $remainingUsers = $allUsers->slice(3);
        } else {
            $users = $allUsers->take(5);
            $remainingUsers = collect();
        }

        return view('livewire.ranking-table', [
            'users' => $users,
            'top3' => $top3,
            'remainingUsers' => $remainingUsers,
            'isAdmin' => $isAdmin,
            'currentPosition' => $currentPosition,
            'currentUserRecord' => $currentUserRecord,
            'showCurrentUserRow' => ! $isAdmin && $currentUserRecord && $currentPosition > 5,
        ]);
    }
}
