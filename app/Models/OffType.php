<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OffType extends Model
{
    //
    /** @use HasFactory<\Database\Factories\OffTypeFactory> */
    use SoftDeletes, HasFactory;

    protected $guarded = [];
    protected $table = 'off_types';
    public static $snakeAttributes = false;


    public function employee_offDays()
    {
        return $this->hasMany(EmployeeOffDay::class, 'off_type_id', 'id');
    }

    public function offDays()
    {
        return $this->hasMany(OffDay::class, 'off_type_id', 'id');
    }
}
