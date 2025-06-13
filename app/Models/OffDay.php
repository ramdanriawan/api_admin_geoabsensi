<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Testing\Fluent\Concerns\Has;

class OffDay extends Model
{
    //
    /** @use HasFactory<\Database\Factories\OffDayFactory> */
    use SoftDeletes, HasFactory;
    protected $guarded = [];
    protected $table   = 'offdays';

    /**
     * Get the employee that owns the OffDay
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }


    /**
     * Get the off_type that owns the OffDay
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function off_type(): BelongsTo
    {
        return $this->belongsTo(OffType::class);
    }
}
