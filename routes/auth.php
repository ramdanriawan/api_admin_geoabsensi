<?php

use App\Http\Controllers\Web\Admin\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    Route::get('login', function () {
        return redirect(route('web.admin.login'));
    })->name('login');
});
