<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserShift extends Model
{
    //
    /** @use HasFactory<\Database\Factories\UserShiftFactory> */
    use SoftDeletes, HasFactory;

    protected $guarded = [];
    protected $table = 'user_shifts';

    public function shift() {
        return $this->belongsTo(Shift::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
