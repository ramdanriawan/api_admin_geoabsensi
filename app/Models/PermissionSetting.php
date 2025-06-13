<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermissionSetting extends Model
{
    //
    /** @use HasFactory<\Database\Factories\PermissionSettingFactory> */
    use SoftDeletes, HasFactory;
    protected $guarded = [];

    protected $table = 'permission_settings';
}
