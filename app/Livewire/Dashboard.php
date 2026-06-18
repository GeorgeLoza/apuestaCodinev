<?php

namespace App\Livewire;

use App\Models\FootballMatch;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view(
            'livewire.dashboard',
            [
                'matches' => FootballMatch::query()
                    ->orderBy('fecha_partido')
                    ->take(10)
                    ->get(),
            ]
        );
    }
}