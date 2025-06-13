<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationSetting extends Model
{
    //
    /** @use HasFactory<\Database\Factories\NotificationSettingFactory> */
    use SoftDeletes, HasFactory;
    protected $guarded = [];

    protected $table = 'notification_settings';
}
