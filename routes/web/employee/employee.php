<?php

use Illuminate\Support\Facades\Route;

Route::any('/', function () {
    return redirect()->route('web.admin.login');
});
