<?php

namespace App\Jobs;

use App\Actions\SyncMatchesAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SyncMatchesJob implements ShouldQueue
{
    use Queueable;

    public function handle(
        SyncMatchesAction $action
    ): void {
        $action->execute();
    }
}