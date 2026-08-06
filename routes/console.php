<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:backup-database-and-media')
    ->daily()
    ->at('02:00') // Jalankan setiap jam 2 pagi saat traffic sepi
    ->appendOutputTo(storage_path('logs/backup.log'));
