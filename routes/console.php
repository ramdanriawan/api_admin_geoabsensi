<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


if (app()->runningInConsole() && $_SERVER['argv'][1] === 'schedule:work') {

    \Illuminate\Support\Facades\Schedule::job(new \App\Jobs\AttendanceAddNotPresentJob())->everyMinute();
}
