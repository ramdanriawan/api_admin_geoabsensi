<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;

interface AttendanceService {
    public static function store(User $user, UploadedFile $picture, $lat, $lng);

    public static function findByUserId(int $userId);

    public static function endAttendance(User $user, UploadedFile $picture, $lat, $lng);



}
