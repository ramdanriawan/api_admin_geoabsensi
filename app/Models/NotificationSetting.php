<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationSetting extends Model
{
    //
    use SoftDeletes;
    protected $guarded = [];

    protected $table = 'notification_settings';
}
