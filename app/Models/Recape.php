<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recape extends Model
{
    //
    /** @use HasFactory<\Database\Factories\RecapeFactory> */
    use SoftDeletes, HasFactory;
    protected $guarded = [];
    protected $table = 'recapes';
}
