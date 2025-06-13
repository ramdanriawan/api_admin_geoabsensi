<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OverTime extends Model
{
    //
    /** @use HasFactory<\Database\Factories\OverTimeFactory> */
    use SoftDeletes, HasFactory;
    protected $guarded = [];
    protected $table = 'overtimes';

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
}
