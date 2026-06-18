<?php
use App\Jobs\SyncMatchesJob;
use Illuminate\Support\Facades\Schedule;

Schedule::job(
    new SyncMatchesJob()
)->everyThirtyMinutes();