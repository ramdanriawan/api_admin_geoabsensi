<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    //
    use SoftDeletes;
    protected $guarded = [];
    protected $table   = 'attendances';

    /**
     * Get the break associated with the Attendance
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function breakTime(): HasOne
    {
        return $this->hasOne(BreakTime::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function overTime()
    {
        return  $this->hasOne(OverTime::class);
    }
}
