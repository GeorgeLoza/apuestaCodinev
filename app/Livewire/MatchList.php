<?php

namespace App\Livewire;

use App\Actions\CreatePredictionAction;
use App\Models\FootballMatch;
use App\Models\Prediction;
use App\Models\Tournament;
use Carbon\Carbon;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Partidos y Pronósticos')]
class MatchList extends Component
{
    public string $selectedPhase = 'todos';
    public string $predictionFilter = 'todos';
    
    public array $predictions = [];

    protected $rules = [
        'predictions.*.goles_local' => 'required|integer|min:0|max:20',
        'predictions.*.goles_visitante' => 'required|integer|min:0|max:20',
    ];

    protected $messages = [
        'predictions.*.goles_local.required' => 'Requerido',
        'predictions.*.goles_local.integer' => 'Debe ser número',
        'predictions.*.goles_visitante.required' => 'Requerido',
        'predictions.*.goles_visitante.integer' => 'Debe ser número',
    ];

    public function mount(): void
    {
        $this->loadPredictions();
    }

    public function loadPredictions(): void
    {
        $user = Auth::user();
        $matches = FootballMatch::all();
        $userPredictions = Prediction::where('user_id', $user->id)->get()->keyBy('partido_id');

        foreach ($matches as $match) {
            $pred = $userPredictions->get($match->id);
            $this->predictions[$match->id] = [
                'goles_local' => $pred ? (string)$pred->goles_local : '',
                'goles_visitante' => $pred ? (string)$pred->goles_visitante : '',
            ];
        }
    }

    public function savePrediction(int $matchId, CreatePredictionAction $action): void
    {
        $this->validate([
            "predictions.{$matchId}.goles_local" => 'required|integer|min:0|max:20',
            "predictions.{$matchId}.goles_visitante" => 'required|integer|min:0|max:20',
        ]);

        $golesLocal = (int) $this->predictions[$matchId]['goles_local'];
        $golesVisitante = (int) $this->predictions[$matchId]['goles_visitante'];
        $userId = Auth::id();

        try {
            $action->execute($userId, $matchId, $golesLocal, $golesVisitante);
            Flux::toast(variant: 'success', text: '¡Pronóstico guardado correctamente!');
        } catch (\Exception $e) {
            Flux::toast(variant: 'danger', text: 'Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $query = FootballMatch::query()
            ->with(['homeTeam', 'awayTeam', 'predictions' => function ($q) {
                $q->where('user_id', Auth::id());
            }])
            ->orderBy('fecha_partido');

        // Filter by Phase
        if ($this->selectedPhase !== 'todos') {
            if ($this->selectedPhase === 'eliminatorias') {
                $query->whereIn('tipo', ['dieciseisavos', 'octavos', 'cuartos', 'semifinal', 'tercer_puesto', 'final']);
            } else {
                $query->where('tipo', $this->selectedPhase);
            }
        }

        $matches = $query->get();

        // Filter by Prediction Status
        if ($this->predictionFilter !== 'todos') {
            $matches = $matches->filter(function ($match) {
                $hasPrediction = $match->predictions->isNotEmpty();
                if ($this->predictionFilter === 'pronosticados') {
                    return $hasPrediction;
                }
                if ($this->predictionFilter === 'pendientes') {
                    $isOpen = Carbon::now()->lessThan($match->fecha_cierre_apuestas);
                    return !$hasPrediction && $isOpen;
                }
                return true;
            });
        }

        return view('livewire.match-list', [
            'matches' => $matches,
            'phases' => [
                'todos' => 'Todos los Partidos',
                'grupo' => 'Fase de Grupos',
                'eliminatorias' => 'Rondas Eliminatorias',
                'octavos' => 'Octavos de Final',
                'cuartos' => 'Cuartos de Final',
                'semifinal' => 'Semifinales',
                'final' => 'Final',
            ]
        ]);
    }
}
