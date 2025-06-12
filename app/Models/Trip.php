<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    //
    use SoftDeletes;
    protected $guarded = [];
    protected $table   = 'trips';

    /**
     * Get the trip_type that owns the Trip
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trip_type(): BelongsTo
    {
        return $this->belongsTo(TripType::class);
    }

    /**
     * Get the trip_attendance associated with the Trip
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function trip_attendance(): HasOne
    {
        return $this->hasOne(TripAttendance::class, 'trip_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
