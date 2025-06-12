<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Web\Admin\ApiV1WebAdminUserController;
use App\Http\Controllers\Api\V1\Web\Admin\ApiV1WebAdminEmployeeController;
use App\Http\Controllers\Api\V1\Web\Admin\ApiV1WebAdminEmployeeOffDayController;
use App\Http\Controllers\Api\V1\Web\Admin\ApiV1WebAdminTitleController;
use App\Http\Controllers\Api\V1\Web\Admin\ApiV1WebAdminApplicationController;
use App\Http\Controllers\Api\V1\Web\Admin\ApiV1WebAdminOrganizationController;
use App\Http\Controllers\Api\V1\Web\Admin\ApiV1WebAdminShiftController;
use App\Http\Controllers\Api\V1\Web\Admin\ApiV1WebAdminMotivationalController;
use App\Http\Controllers\Api\V1\Web\Admin\ApiV1WebAdminAttendanceController;
use App\Http\Controllers\Api\V1\Web\Admin\ApiV1WebAdminBreakTimeController;
use App\Http\Controllers\Api\V1\Web\Admin\ApiV1WebAdminOverTimeController;
use App\Http\Controllers\Api\V1\Web\Admin\ApiV1WebAdminTripController;
use App\Http\Controllers\Api\V1\Web\Admin\ApiV1WebAdminVisitController;
use App\Http\Controllers\Api\V1\Web\Admin\ApiV1WebAdminOffDayController;
use App\Http\Controllers\Api\V1\Web\Admin\ApiV1WebAdminPaySlipController;
use App\Http\Controllers\Api\V1\Web\Admin\ApiV1WebAdminUserShiftController;
use App\Http\Controllers\Api\V1\Web\Admin\ApiV1WebAdminOffTypeController;
use App\Http\Controllers\Api\V1\Web\Admin\ApiV1WebAdminTripTypeController;
use App\Http\Controllers\Api\V1\Web\Admin\ApiV1WebAdminVisitTypeController;
use App\Http\Controllers\Api\V1\Web\Admin\ApiV1WebAdminRecapeController;

Route::middleware(['web', 'auth'])->group(function () {

    Route::get('/user/select2', [ApiV1WebAdminUserController::class, 'select2'])->name('user.select2');
    Route::match(['get', 'post'], "user/{user}/updateStatus", [ApiV1WebAdminUserController::class, 'updateStatus'])->name('user.updateStatus');
    Route::get("user/datatable", [ApiV1WebAdminUserController::class, 'dataTable'])->name('user.dataTable');
    Route::get("user/{user}/delete", [ApiV1WebAdminUserController::class, 'delete'])->name('user.delete');

    Route::get("employee/datatable", [ApiV1WebAdminEmployeeController::class, 'dataTable'])->name('employee.dataTable');
    Route::get("employee/{employee}/delete", [ApiV1WebAdminEmployeeController::class, 'delete'])->name('employee.delete');

    Route::get('/title/select2', [ApiV1WebAdminTitleController::class, 'select2'])->name('title.select2');
    Route::get("title/datatable", [ApiV1WebAdminTitleController::class, 'dataTable'])->name('title.dataTable');
    Route::get("title/{title}/delete", [ApiV1WebAdminTitleController::class, 'delete'])->name('title.delete');

    Route::get("application/datatable", [ApiV1WebAdminApplicationController::class, 'dataTable'])->name('application.dataTable');
    Route::get("application/{application}/delete", [ApiV1WebAdminApplicationController::class, 'delete'])->name('application.delete');

    Route::get("organization/datatable", [ApiV1WebAdminOrganizationController::class, 'dataTable'])->name('organization.dataTable');
    Route::get("organization/{organization}/delete", [ApiV1WebAdminOrganizationController::class, 'delete'])->name('organization.delete');

    Route::get('/shift/select2', [ApiV1WebAdminShiftController::class, 'select2'])->name('shift.select2');
    Route::get("shift/datatable", [ApiV1WebAdminShiftController::class, 'dataTable'])->name('shift.dataTable');
    Route::get("shift/{shift}/delete", [ApiV1WebAdminShiftController::class, 'delete'])->name('shift.delete');

    Route::get('/userShift/getUserSelect2', [ApiV1WebAdminUserShiftController::class, 'getUserSelect2'])->name('userShift.getUserSelect2');
    Route::get('/userShift/getShiftSelect2', [ApiV1WebAdminUserShiftController::class, 'getShiftSelect2'])->name('userShift.getShiftSelect2');
    Route::get("userShift/datatable", [ApiV1WebAdminUserShiftController::class, 'dataTable'])->name('userShift.dataTable');
    Route::get("userShift/{userShift}/delete", [ApiV1WebAdminUserShiftController::class, 'delete'])->name('userShift.delete');

    Route::get('/employeeOffDay/getEmployeeSelect2', [ApiV1WebAdminEmployeeOffDayController::class, 'getEmployeeSelect2'])->name('employeeOffDay.getEmployeeSelect2');
    Route::get('/employeeOffDay/getOffTypeSelect2', [ApiV1WebAdminEmployeeOffDayController::class, 'getOffTypeSelect2'])->name('employeeOffDay.getOffTypeSelect2');
    Route::get("employeeOffDay/datatable", [ApiV1WebAdminEmployeeOffDayController::class, 'dataTable'])->name('employeeOffDay.dataTable');
    Route::get("employeeOffDay/{employeeOffDay}/delete", [ApiV1WebAdminEmployeeOffDayController::class, 'delete'])->name('employeeOffDay.delete');

    Route::get("offType/datatable", [ApiV1WebAdminOffTypeController::class, 'dataTable'])->name('offType.dataTable');
    Route::get("offType/{offType}/delete", [ApiV1WebAdminOffTypeController::class, 'delete'])->name('offType.delete');

    Route::get("tripType/datatable", [ApiV1WebAdminTripTypeController::class, 'dataTable'])->name('tripType.dataTable');
    Route::get("tripType/{tripType}/delete", [ApiV1WebAdminTripTypeController::class, 'delete'])->name('tripType.delete');

    Route::get("motivational/datatable", [ApiV1WebAdminMotivationalController::class, 'dataTable'])->name('motivational.dataTable');
    Route::get("motivational/{motivational}/delete", [ApiV1WebAdminMotivationalController::class, 'delete'])->name('motivational.delete');

    Route::get("attendance/datatable", [ApiV1WebAdminAttendanceController::class, 'dataTable'])->name('attendance.dataTable');

    Route::get("breakTime/datatable", [ApiV1WebAdminBreakTimeController::class, 'dataTable'])->name('breakTime.dataTable');

    Route::match(['get', 'post'], "overTime/{overTime}/updateStatus", [ApiV1WebAdminOverTimeController::class, 'updateStatus'])->name('overTime.updateStatus');
    Route::get("overTime/datatable", [ApiV1WebAdminOverTimeController::class, 'dataTable'])->name('overTime.dataTable');

    Route::match(['get', 'post'], "trip/{trip}/updateStatus", [ApiV1WebAdminTripController::class, 'updateStatus'])->name('trip.updateStatus');
    Route::get("trip/datatable", [ApiV1WebAdminTripController::class, 'dataTable'])->name('trip.dataTable');

    Route::get("visitType/datatable", [ApiV1WebAdminVisitTypeController::class, 'dataTable'])->name('visitType.dataTable');
    Route::get("visitType/{visitType}/delete", [ApiV1WebAdminVisitTypeController::class, 'delete'])->name('visitType.delete');

    Route::match(['get', 'post'], "visit/{visit}/updateStatus", [ApiV1WebAdminVisitController::class, 'updateStatus'])->name('visit.updateStatus');
    Route::get("visit/datatable", [ApiV1WebAdminVisitController::class, 'dataTable'])->name('visit.dataTable');




    Route::match(['get', 'post'], "offDay/{offDay}/updateStatus", [ApiV1WebAdminOffDayController::class, 'updateStatus'])->name('offDay.updateStatus');
    Route::get("offDay/datatable", [ApiV1WebAdminOffDayController::class, 'dataTable'])->name('offDay.dataTable');

    Route::get('/paySlip/getUserSelect2', [ApiV1WebAdminPaySlipController::class, 'getUserSelect2'])->name('paySlip.getUserSelect2');
    Route::match(['get', 'post'], "paySlip/{paySlip}/updateStatus", [ApiV1WebAdminPaySlipController::class, 'updateStatus'])->name('paySlip.updateStatus');
    Route::get("paySlip/datatable", [ApiV1WebAdminPaySlipController::class, 'dataTable'])->name('paySlip.dataTable');
    Route::get("paySlip/{paySlip}/delete", [ApiV1WebAdminPaySlipController::class, 'delete'])->name('paySlip.delete');

    Route::get('/recape/getByUserFromStartDateToEndDate', [ApiV1WebAdminRecapeController::class, 'getByUserFromStartDateToEndDate'])->name('recape.getByUserFromStartDateToEndDate');
    Route::match(['get', 'post'], "recape/{recape}/updateStatus", [ApiV1WebAdminRecapeController::class, 'updateStatus'])->name('recape.updateStatus');
    Route::get("recape/datatable", [ApiV1WebAdminRecapeController::class, 'dataTable'])->name('recape.dataTable');

});
