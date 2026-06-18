<?php

namespace App\Livewire;

use App\Actions\CreatePredictionAction;
use App\Models\FootballMatch;
use App\Models\Prediction;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PredictionForm extends Component
{
    public FootballMatch $match;
    public string $golesLocal = '';
    public string $golesVisitante = '';

    protected $rules = [
        'golesLocal' => 'required|integer|min:0|max:20',
        'golesVisitante' => 'required|integer|min:0|max:20',
    ];

    public function mount(FootballMatch $match): void
    {
        $this->match = $match;
        $prediction = Prediction::where('user_id', Auth::id())
            ->where('partido_id', $match->id)
            ->first();

        if ($prediction) {
            $this->golesLocal = (string) $prediction->goles_local;
            $this->golesVisitante = (string) $prediction->goles_visitante;
        }
    }

    public function save(CreatePredictionAction $action): void
    {
        $this->validate();

        try {
            $action->execute(
                Auth::id(),
                $this->match->id,
                (int) $this->golesLocal,
                (int) $this->golesVisitante
            );
            Flux::toast(variant: 'success', text: '¡Pronóstico guardado!');
            $this->dispatch('prediction-saved');
        } catch (\Exception $e) {
            Flux::toast(variant: 'danger', text: 'Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.prediction-form');
    }
}
