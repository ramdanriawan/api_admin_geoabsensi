<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RamdanRiawan\DateTime;

class Shift extends Model
{
    /** @use HasFactory<\Database\Factories\ShiftFactory> */
    use SoftDeletes, HasFactory;
    protected $guarded = [];
    protected $table   = 'shifts';

    public function user_shifts()
    {
        return $this->hasMany(UserShift::class);
    }
}
