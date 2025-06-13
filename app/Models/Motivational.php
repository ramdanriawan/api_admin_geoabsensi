<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Motivational extends Model
{
    //
    /** @use HasFactory<\Database\Factories\MotivationalFactory> */
    use SoftDeletes, HasFactory;

    protected $guarded = [];
    protected $table = 'motivationals';
}
