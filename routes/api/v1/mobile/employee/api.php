<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Services\ServiceImpl\UserServiceImpl;
use RamdanRiawan\ResponseJson;
use App\Http\Controllers\Api\V1\Mobile\Employee\MotivationalController;
use App\Http\Controllers\Api\V1\Mobile\Employee\UserShiftController;
use App\Http\Controllers\Api\V1\Mobile\Employee\ApplicationController;
use App\Http\Controllers\Api\V1\Mobile\Employee\AttendanceController;
use App\Http\Controllers\Api\V1\Mobile\Employee\HistoryBreakTimeController;
use App\Http\Controllers\Api\V1\Mobile\Employee\BreakTimeController;
use App\Http\Controllers\Api\V1\Mobile\Employee\OverTimeController;
use App\Http\Controllers\Api\V1\Mobile\Employee\HistoryOffDayController;
use App\Http\Controllers\Api\V1\Mobile\Employee\HistoryTripController;
use App\Http\Controllers\Api\V1\Mobile\Employee\HistoryVisitController;
use App\Http\Controllers\Api\V1\Mobile\Employee\PaySlipController;
use App\Http\Controllers\Api\V1\Mobile\Employee\RecapeController;
use App\Http\Controllers\Api\V1\Mobile\Employee\HistoryOverTimeController;
use App\Http\Controllers\Api\V1\Mobile\Employee\OffDayController;
use App\Http\Controllers\Api\V1\Mobile\Employee\TripController;
use App\Http\Controllers\Api\V1\Mobile\Employee\VisitController;

Route::match(['get', 'post'], "/user/login", function (Request $request) {
    if ($userTokenModel = UserServiceImpl::loginMobile($request->email, $request->password)) {

        return ResponseJson::success($userTokenModel);
    }

    return ResponseJson::unauthorized();
})->name('login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('user')->group(function () {

        Route::match(['get', 'post'], '/me', function (Request $request) {
            return ResponseJson::success(UserServiceImpl::findOne($request->user()->id));
        });

        Route::match(['get', 'post'], "/logout", function (Request $request) {
            UserServiceImpl::logout($request->user());

            return ResponseJson::success(null);
        })->name('logout');

        Route::match(['get', 'post'], "/update-photo-profile", function (Request $request) {
            $user = UserServiceImpl::updatePhotoProfile($request->user(), $request->file('picture'));

            return ResponseJson::success($user);
        })->name('update-photo-profile');
    });

    // motivational
    Route::match(['get', 'post'], 'motivational/last', [MotivationalController::class, 'last'])->name("motivational.last");
    Route::apiResource('motivational', MotivationalController::class)->parameters([
        'motivational' => 'motivational',
    ]);

    // shift
    Route::match(['get', 'post'], 'user-shift/find-one-by-user-login', [UserShiftController::class, 'findOneByUserLogin'])->name("userShift.findOneByUser");
    Route::apiResource('user-shift', UserShiftController::class);

    // application
    Route::prefix('application')->group(function () {

        Route::match(['get', 'post'], '/info', [ApplicationController::class, 'info']);
    });

    Route::get('attendance/find-by-user-id', [AttendanceController::class, 'findByUserId']);
    Route::post('attendance/end-attendance', [AttendanceController::class, 'endAttendance']);
    Route::apiResource('attendance', AttendanceController::class);

    Route::get('break-time/history/find-all-by-current-user', [HistoryBreakTimeController::class, 'findAllByCurrentUser']);
    Route::post('break-time/end', [BreakTimeController::class, 'end']);
    Route::get('break-time/find-by-attendance-id/{attendanceId}', [BreakTimeController::class, 'findByAttendanceId']);
    Route::get('break-time/find-by-user-id', [BreakTimeController::class, 'findByUserId']);
    Route::apiResource('break-time', BreakTimeController::class);

    Route::get('over-time/history/find-all-by-current-user', [HistoryOverTimeController::class, 'findAllByCurrentUser']);
    Route::post('over-time/end', [OverTimeController::class, 'end']);
    Route::get('over-time/find-by-attendance-id/{attendance}', [OverTimeController::class, 'findByAttendanceId']);
    Route::get('over-time/find-by-user-id', [OverTimeController::class, 'findByUserId']);
    Route::apiResource('over-time', OverTimeController::class);

    Route::get('off-day/history/find-all-by-current-user', [HistoryOffDayController::class, 'findAllByCurrentUser']);
    Route::post('off-day/end', [OffDayController::class, 'end']);
    Route::get('off-day/find-last-by-user-id', [OffDayController::class, 'findLastByUserId']);
    Route::apiResource('off-day', OffDayController::class);

    Route::get('trip/history/find-all-by-current-user', [HistoryTripController::class, 'findAllByCurrentUser']);
    Route::post('trip/end', [TripController::class, 'end']);
    Route::get('trip/find-last-by-user-id', [TripController::class, 'findLastByUserId']);
    Route::apiResource('trip', TripController::class);

    Route::get('visit/history/find-all-by-current-user', [HistoryVisitController::class, 'findAllByCurrentUser']);
    Route::get('visit/find-by-user-id', [VisitController::class, 'findByUserId']);
    Route::apiResource('visit', VisitController::class);

    Route::get('pay-slip/find-one-by-id/{id}', [PaySlipController::class, 'findOneById']);
    Route::get('pay-slip/find-last-by-user-id', [PaySlipController::class, 'findLastByUserId']);
    Route::apiResource('pay-slip', PaySlipController::class);

    Route::get('recape/find-one-by-id/{id}', [RecapeController::class, 'findOneById']);
    Route::get('recape/find-last-by-user-id', [RecapeController::class, 'findLastByUserId']);
    Route::apiResource('recape', RecapeController::class);
});
