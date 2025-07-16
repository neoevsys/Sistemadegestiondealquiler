<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Programar el comando para gestionar estados de reservas
Schedule::command('reservas:gestionar-estados')
    ->hourly()
    ->description('Gestiona automáticamente los estados de las reservas cada hora');
