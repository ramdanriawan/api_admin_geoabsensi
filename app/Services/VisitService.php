<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;

interface VisitService {
    public static function store(User $user, UploadedFile $picture, $lat, $lng, $visitTypeId);
}
