<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class TripAttendance extends Model
{
    //
    /** @use HasFactory<\Database\Factories\TripAttendanceFactory> */
    use SoftDeletes, HasFactory;
    protected $guarded = [];
    protected $table   = 'trip_attendances';

    /**
     * Get the break associated with the TripAttendance
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
}
