<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    //
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use SoftDeletes, HasFactory;

    protected $guarded = [];
    protected $table = 'employees';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function title()
    {
        return $this->belongsTo(Title::class);
    }

    public function employee_offDays()
    {
        return $this->hasMany(EmployeeOffDay::class);
    }
}
