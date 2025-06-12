<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermissionSetting extends Model
{
    //
    use SoftDeletes;
    protected $guarded = [];

    protected $table = 'permission_settings';
}
