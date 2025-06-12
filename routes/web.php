<?php

use App\Http\Controllers\Web\Admin\ProfileController;
use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

Route::get(App::currentLocale() . '/locale/change/{locale}', function ($locale) {
    Cookie::queue(Cookie::forever('locale', $locale));
    App::setLocale($locale);

    return redirect()->route('web.admin.welcome');
})->name('locale.change');

Route::middleware([
    LocaleMiddleware::class,
    \App\Http\Middleware\GlobalVariableMiddleware::class,
])->group(function () {

    // khusus route user
    include base_path('routes/web/employee/employee.php');

    // khusus route admin
    include base_path('routes/web/admin/admin.php');

    // khusus route auth default
    include base_path('routes/auth.php');
});
