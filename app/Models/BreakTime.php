<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BreakTime extends Model {
    //

    /** @use HasFactory<\Database\Factories\BreakTimeFactory> */
    use SoftDeletes, HasFactory;
    protected $guarded = [];
    protected $table = 'breaks';

    /**
     * Get the attendance that owns the Break
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attendance(): BelongsTo
    {
        return $this->belongsTo(Attendance::class);
    }
}
