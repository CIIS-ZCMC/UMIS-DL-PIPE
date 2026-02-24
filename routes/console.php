<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('app:pull-device-logs')->everyFifteenMinutes();

Schedule::command('app:push-device-logs')->everyThirtyMinutes();



// Schedule::command('app:pull-device-logs')->everyMinute();

// Schedule::command('app:push-device-logs')->everyMinute();
