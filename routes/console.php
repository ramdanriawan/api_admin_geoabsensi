<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


if (!App::runningInConsole()) {

    \Illuminate\Support\Facades\Schedule::job(new \App\Jobs\AttendanceAddNotPresentJob())->everyMinute();
}
