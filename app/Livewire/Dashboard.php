<?php

namespace App\Livewire;

use App\Actions\CreatePredictionAction;
use App\Models\FootballMatch;
use App\Models\Prediction;
use App\Models\User;
use Carbon\Carbon;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Inicio')]
class Dashboard extends Component
{
    public array $quickPredictions = [];

    protected $rules = [
        'quickPredictions.*.goles_local' => 'required|integer|min:0|max:20',
        'quickPredictions.*.goles_visitante' => 'required|integer|min:0|max:20',
    ];

    public function mount(): void
    {
        $this->loadQuickPredictions();
    }

    public function loadQuickPredictions(): void
    {
        $upcomingMatches = FootballMatch::query()
            ->where('fecha_cierre_apuestas', '>', Carbon::now())
            ->orderBy('fecha_partido')
            ->take(5)
            ->get();

        $userPredictions = Prediction::where('user_id', Auth::id())
            ->whereIn('partido_id', $upcomingMatches->pluck('id'))
            ->get()
            ->keyBy('partido_id');

        foreach ($upcomingMatches as $match) {
            $pred = $userPredictions->get($match->id);
            $this->quickPredictions[$match->id] = [
                'goles_local' => $pred ? (string)$pred->goles_local : '',
                'goles_visitante' => $pred ? (string)$pred->goles_visitante : '',
            ];
        }
    }

    public function saveQuickPrediction(int $matchId, CreatePredictionAction $action): void
    {
        $this->validate([
            "quickPredictions.{$matchId}.goles_local" => 'required|integer|min:0|max:20',
            "quickPredictions.{$matchId}.goles_visitante" => 'required|integer|min:0|max:20',
        ]);

        $golesLocal = (int) $this->quickPredictions[$matchId]['goles_local'];
        $golesVisitante = (int) $this->quickPredictions[$matchId]['goles_visitante'];

        try {
            $action->execute(Auth::id(), $matchId, $golesLocal, $golesVisitante);
            Flux::toast(variant: 'success', text: '¡Pronóstico guardado correctamente!');
        } catch (\Exception $e) {
            Flux::toast(variant: 'danger', text: 'Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $userId = Auth::id();

        // 1. User Statistics
        $totalPoints = (int) Prediction::where('user_id', $userId)->sum('puntos');
        $predictionsCount = Prediction::where('user_id', $userId)->count();
        $totalMatches = FootballMatch::count();

        // 2. Ranking Position
        $usersWithPoints = User::query()
            ->withSum('predictions', 'puntos')
            ->get()
            ->map(fn($u) => [
                'id' => $u->id,
                'points' => (int) ($u->predictions_sum_puntos ?? 0)
            ])
            ->sortByDesc('points')
            ->values();

        $rankingPosition = 1;
        foreach ($usersWithPoints as $index => $u) {
            if ($u['id'] === $userId) {
                $rankingPosition = $index + 1;
                break;
            }
        }

        // 3. Mini Leaderboard (Top 5)
        $leaderboard = User::query()
            ->withSum('predictions', 'puntos')
            ->get()
            ->map(function ($u) {
                $u->total_points = (int) ($u->predictions_sum_puntos ?? 0);
                return $u;
            })
            ->sortByDesc('total_points')
            ->take(5)
            ->values();

        // 4. Upcoming Matches
        $upcomingMatches = FootballMatch::query()
            ->with(['homeTeam', 'awayTeam'])
            ->where('fecha_cierre_apuestas', '>', Carbon::now())
            ->orderBy('fecha_partido')
            ->take(4)
            ->get();

        // 5. Recent Results
        $recentResults = FootballMatch::query()
            ->with(['homeTeam', 'awayTeam', 'predictions' => function ($q) use ($userId) {
                $q->where('user_id', $userId);
            }])
            ->where('estado', 'finalizado')
            ->orderByDesc('fecha_partido')
            ->take(4)
            ->get();

        return view('livewire.dashboard', [
            'totalPoints' => $totalPoints,
            'predictionsCount' => $predictionsCount,
            'totalMatches' => $totalMatches,
            'rankingPosition' => $rankingPosition,
            'leaderboard' => $leaderboard,
            'upcomingMatches' => $upcomingMatches,
            'recentResults' => $recentResults,
        ]);
    }
}