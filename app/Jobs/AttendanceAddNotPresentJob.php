<?php

namespace App\Jobs;

use App\Models\Attendance;
use App\Models\Title;
use App\Models\User;
use App\Services\AttendanceService;
use App\Services\ServiceImpl\AttendanceServiceImpl;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AttendanceAddNotPresentJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
        self::handle();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        \Log::info('Add Not Present Job executed at ' . now());

        $attendanceUsersIds = Attendance::where([
            'date' =>  date('Y-m-d')
        ])->pluck('user_id')->toArray();

        $user = User::whereNotIn('id', $attendanceUsersIds)
            ->where(['status' => 'active'])
            ->whereIn('level', ['employee'])
            ->get();

        foreach ($user as $item) {
            AttendanceServiceImpl::addNotPresent($item);
        }
    }
}
