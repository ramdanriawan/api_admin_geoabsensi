<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1/web/admin')->name('api.v1.web.admin.')->group(function () {
    include base_path('routes/api/v1/web/admin/api.php');
});

Route::prefix('v1')->name('api.v1.mobile.employee.')->group(function () {
    include base_path('routes/api/v1/mobile/employee/api.php');
});
