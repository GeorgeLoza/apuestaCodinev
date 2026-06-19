<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncMatchesNow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-matches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the SyncMatchesAction now';

    public function handle()
    {
        app(\App\Actions\SyncMatchesAction::class)->execute();

        $this->info('SyncMatchesAction executed.');

        return 0;
    }
}
