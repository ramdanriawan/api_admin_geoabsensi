<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Admin\WebAdminUserController;
use App\Http\Controllers\Web\Admin\ProfileController;
use App\Http\Controllers\Web\Admin\WebAdminApplicationController;
use App\Http\Controllers\Web\Admin\WebAdminOrganizationController;
use App\Http\Controllers\Web\Admin\WebAdminShiftController;
use App\Http\Controllers\Web\Admin\WebAdminTitleController;
use App\Http\Controllers\Web\Admin\WebAdminEmployeeController;
use App\Http\Controllers\Web\Admin\WebAdminEmployeeOffDayController;
use App\Http\Controllers\Web\Admin\WebAdminMotivationalController;
use App\Http\Controllers\Web\Admin\WebAdminAttendanceController;
use App\Http\Controllers\Web\Admin\WebAdminBreakTimeController;
use App\Http\Controllers\Web\Admin\WebAdminOverTimeController;
use App\Http\Controllers\Web\Admin\WebAdminTripController;
use App\Http\Controllers\Web\Admin\WebAdminVisitController;
use App\Http\Controllers\Web\Admin\WebAdminOffDayController;
use App\Http\Controllers\Web\Admin\WebAdminPaySlipController;
use App\Http\Controllers\Web\Admin\WebAdminRecapeController;
use App\Http\Controllers\Web\Admin\WebAdminUserShiftController;
use App\Http\Controllers\Web\Admin\WebAdminOffTypeController;
use App\Http\Controllers\Web\Admin\WebAdminTripTypeController;
use App\Http\Controllers\Web\Admin\WebAdminVisitTypeController;
use App\Http\Controllers\Web\Admin\WebAdminRoleController;
use App\Http\Controllers\Web\Admin\WebAdminDashboardController;

Route::prefix('web/admin')->name('web.admin.')->group(function () {

    Route::middleware(['auth', 'role:admin', \App\Http\Middleware\GlobalVariableMiddleware::class, \App\Http\Middleware\WebAdminGlobalVariableMiddleware::class])->group(function () {
        Route::get('/dashboard', [WebAdminDashboardController::class, 'index'])->name('dashboard.index');

        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });

        Route::resource('/application', WebAdminApplicationController::class)->parameters([
            'application' => 'application'
        ]);

        Route::resource('/organization', WebAdminOrganizationController::class)->parameters([
            'organization' => 'organization'
        ]);

        Route::resource('/shift', WebAdminShiftController::class)->parameters([
            'shift' => 'shift'
        ]);

        Route::resource('/user', WebAdminUserController::class)->parameters([
            'user' => 'user'
        ]);

        Route::resource('/userShift', WebAdminUserShiftController::class)->parameters([
            'userShift' => 'userShift'
        ]);

        Route::resource('/offType', WebAdminOffTypeController::class)->parameters([
            'offType' => 'offType'
        ]);

        Route::resource('/title', WebAdminTitleController::class)->parameters([
            'title' => 'title'
        ]);


        Route::resource('/employee', WebAdminEmployeeController::class)->parameters([
            'employee' => 'employee'
        ]);

        Route::resource('/employeeOffDay', WebAdminEmployeeOffDayController::class)->parameters([
            'employeeOffDay' => 'employeeOffDay'
        ]);

        Route::resource('/motivational', WebAdminMotivationalController::class)->parameters([
            'motivational' => 'motivational'
        ]);

        Route::resource('/attendance', WebAdminAttendanceController::class)->parameters([
            'attendance' => 'attendance'
        ]);

        Route::resource('/breakTime', WebAdminBreakTimeController::class)->parameters([
            'breakTime' => 'breakTime'
        ]);

        Route::resource('/overTime', WebAdminOverTimeController::class)->parameters([
            'overTime' => 'overTime'
        ]);


        Route::resource('/tripType', WebAdminTripTypeController::class)->parameters([
            'tripType' => 'tripType'
        ]);

        Route::resource('/trip', WebAdminTripController::class)->parameters([
            'trip' => 'trip'
        ]);


        Route::resource('/visitType', WebAdminVisitTypeController::class)->parameters([
            'visitType' => 'visitType'
        ]);

        Route::resource('/visit', WebAdminVisitController::class)->parameters([
            'visit' => 'visit'
        ]);

        Route::resource('/offDay', WebAdminOffDayController::class)->parameters([
            'offDay' => 'offDay'
        ]);

        Route::resource('/paySlip', WebAdminPaySlipController::class)->parameters([
            'paySlip' => 'paySlip'
        ]);

        Route::resource('/recape', WebAdminRecapeController::class)->parameters([
            'recape' => 'recape'
        ]);

        // khusus untuk nambahin role
        Route::resource('/role', WebAdminRoleController::class)->parameters([
            'role' => 'role'
        ]);
    });

    require base_path('routes/web/admin/auth.php');
});

