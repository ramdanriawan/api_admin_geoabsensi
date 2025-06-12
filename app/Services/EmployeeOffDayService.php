<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;

interface EmployeeOffDayService {
    public static function store(User $user, $breakType);

    public static function findByUserId(int $userId);

    public static function end(User $user);

    public static function findAll($start, $end);



}
