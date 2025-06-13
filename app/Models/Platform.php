<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Platform extends Model
{
    //
    /** @use HasFactory<\Database\Factories\PlatformFactory> */
    use SoftDeletes, HasFactory;
    protected $guarded = [];
    protected $table = 'platforms';
}
