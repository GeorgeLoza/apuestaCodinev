<?php

namespace App\Console\Commands;

use App\Actions\SyncMatchesAction;
use Illuminate\Console\Command;

class SyncMatchesCommand extends Command
{
    protected $signature = 'football:sync';

    protected $description =
        'Sincroniza partidos desde la API';

    public function handle(
        SyncMatchesAction $action
    ): int {

        $this->info(
            'Sincronizando partidos...'
        );

        $action->execute();

        $this->info(
            'Partidos sincronizados.'
        );

        return self::SUCCESS;
    }
}