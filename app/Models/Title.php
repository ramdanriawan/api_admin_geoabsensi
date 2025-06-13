<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Title extends Model
{
    //
    /** @use HasFactory<\Database\Factories\TitleFactory> */
    use SoftDeletes, HasFactory;
    protected $guarded = [];
    protected $table = 'titles';

    public function employees() {
        return $this->hasMany(Employee::class);
    }
}
