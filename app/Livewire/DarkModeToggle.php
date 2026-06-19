<?php

namespace App\Livewire;

use Livewire\Component;

class DarkModeToggle extends Component
{
    public bool $darkMode = false;

    public function mount(): void
    {
        // Default is set via JavaScript from localStorage
    }

    public function toggle(): void
    {
        $this->darkMode = !$this->darkMode;
        // JavaScript will handle localStorage sync
    }

    public function render()
    {
        return view('livewire.dark-mode-toggle');
    }
}
