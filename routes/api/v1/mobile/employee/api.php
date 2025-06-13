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
    Route::prefix('user')->name('user.')->group(function () {

        Route::match(['get', 'post'], '/me', function (Request $request) {
            return ResponseJson::success(UserServiceImpl::findOne($request->user()->id));
        })->name('me');

        Route::match(['get', 'post'], "/logout", function (Request $request) {
            UserServiceImpl::logout($request->user());

            return ResponseJson::success(null);
        })->name('logout');

        Route::match(['get', 'post'], "/update-photo-profile", function (Request $request) {
            $user = UserServiceImpl::updatePhotoProfile($request->user(), $request->file('picture'));

            return ResponseJson::success($user);
        })->name('updatePhotoProfile');
    });

    // motivational
    Route::match(['get', 'post'], 'motivational/last', [MotivationalController::class, 'last'])->name("motivational.last");
    Route::apiResource('motivational', MotivationalController::class)->parameters([
        'motivational' => 'motivational',
    ])->names("motivational");

    // shift
    Route::match(['get', 'post'], 'user-shift/find-one-by-user-login', [UserShiftController::class, 'findOneByUserLogin'])->name("userShift.findOneByUserLogin");
    Route::apiResource('user-shift', UserShiftController::class)->names('userShift')->parameters([
        'user-shift' => 'userShift',
    ]);

    // application
    Route::prefix('application')->name('application.')->group(function () {

        Route::match(['get', 'post'], '/info', [ApplicationController::class, 'info'])->name('info');
    });

    Route::get('attendance/find-by-user-id', [AttendanceController::class, 'findByUserId'])->name('attendance.findByUserId');
    Route::post('attendance/end-attendance', [AttendanceController::class, 'endAttendance'])->name('attendance.endAttendance');
    Route::apiResource('attendance', AttendanceController::class)->names('attendance')->parameters([
        'attendance' => 'attendance',
    ]);

    Route::get('break-time/history/find-all-by-current-user', [HistoryBreakTimeController::class, 'findAllByCurrentUser'])->name('breakTime.history.findAllByCurrentUser');
    Route::post('break-time/end', [BreakTimeController::class, 'end'])->name('breakTime.end');
    Route::get('break-time/find-by-attendance-id/{attendanceId}', [BreakTimeController::class, 'findByAttendanceId'])->name('breakTime.findByAttendanceId');
    Route::get('break-time/find-by-user-id', [BreakTimeController::class, 'findByUserId'])->name('breakTime.findByUserId');
    Route::apiResource('break-time', BreakTimeController::class)->names('breakTime')->parameters([
        'break-time' => 'breakTime',
    ]);

    Route::get('over-time/history/find-all-by-current-user', [HistoryOverTimeController::class, 'findAllByCurrentUser'])->name('overTime.history.findAllByCurrentUser');
    Route::post('over-time/end', [OverTimeController::class, 'end'])->name('overTime.end');
    Route::get('over-time/find-by-attendance-id/{attendance}', [OverTimeController::class, 'findByAttendanceId'])->name('overTime.findByAttendanceId');
    Route::get('over-time/find-by-user-id', [OverTimeController::class, 'findByUserId'])->name('overTime.findByUserId');
    Route::apiResource('over-time', OverTimeController::class)->names('overTime')->parameters([
        'over-time' => 'overTime',
    ]);

    Route::get('off-day/history/find-all-by-current-user', [HistoryOffDayController::class, 'findAllByCurrentUser'])->name('offDay.history.findAllByCurrentUser');
    Route::post('off-day/end', [OffDayController::class, 'end'])->name('offDay.end');
    Route::get('off-day/find-last-by-user-id', [OffDayController::class, 'findLastByUserId'])->name('offDay.findLastByUserId');
    Route::apiResource('off-day', OffDayController::class)->names('offDay')->parameters([
        'off-day' => 'offDay',
    ]);

    Route::get('trip/history/find-all-by-current-user', [HistoryTripController::class, 'findAllByCurrentUser'])->name('trip.history.findAllByCurrentUser');
    Route::post('trip/end', [TripController::class, 'end'])->name('trip.end');
    Route::get('trip/find-last-by-user-id', [TripController::class, 'findLastByUserId'])->name('trip.findLastByUserId');
    Route::apiResource('trip', TripController::class)->names('trip')->parameters([
        'trip' => 'trip',
    ]);

    Route::get('visit/history/find-all-by-current-user', [HistoryVisitController::class, 'findAllByCurrentUser'])->name('visit.history.findAllByCurrentUser');
    Route::get('visit/find-by-user-id', [VisitController::class, 'findByUserId'])->name('visit.findByUserId');
    Route::apiResource('visit', VisitController::class);

    Route::get('pay-slip/find-one-by-id/{id}', [PaySlipController::class, 'findOneById'])->name('paySlip.findOneById');
    Route::get('pay-slip/find-last-by-user-id', [PaySlipController::class, 'findLastByUserId'])->name('paySlip.findLastByUserId');
    Route::apiResource('pay-slip', PaySlipController::class)->names('paySlip')->parameters([
        'pay-slip' => 'paySlip',
    ]);

    Route::get('recape/find-one-by-id/{id}', [RecapeController::class, 'findOneById'])->name('recape.findOneById');
    Route::get('recape/find-last-by-user-id', [RecapeController::class, 'findLastByUserId'])->name('recape.findLastByUserId');
    Route::apiResource('recape', RecapeController::class)->names('recape')->parameters([
        'recape' => 'recape',
    ]);
});
