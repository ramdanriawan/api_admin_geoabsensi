<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leave extends Model
{
    //
    /** @use HasFactory<\Database\Factories\LeaveFactory> */
    use SoftDeletes, HasFactory;

    protected $guarded = [];
    protected $table = 'leaves';
}
