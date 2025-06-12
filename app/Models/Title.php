<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Title extends Model
{
    //
    use SoftDeletes;
    protected $guarded = [];
    protected $table = 'titles';

    public function employees() {
        return $this->hasMany(Employee::class);
    }
}
