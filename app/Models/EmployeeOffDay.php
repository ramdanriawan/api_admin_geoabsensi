<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeOffDay extends Model
{
    //
    /** @use HasFactory<\Database\Factories\EmployeeOffDayFactory> */
    use SoftDeletes, HasFactory;
    protected $guarded = [];
    protected $table = 'employee_offdays';

    /**
     * Get the employee that owns the EmployeeOffDay
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the offType that owns the EmployeeOffDay
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function off_type(): BelongsTo
    {
        return $this->belongsTo(OffType::class);
    }
}
