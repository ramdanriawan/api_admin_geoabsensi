<?php

namespace App\Providers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\OffDay;
use App\Models\Organization;
use App\Models\OverTime;
use App\Services\ServiceImpl\OrganizationServiceImpl;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //

        Blade::anonymousComponentNamespace('admin.components', 'admin');

    }
}
