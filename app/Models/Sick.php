<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sick extends Model
{
    //
    /** @use HasFactory<\Database\Factories\SickFactory> */
    use SoftDeletes, HasFactory;

    protected $guarded = [];
    protected $table = 'sicks';
}
