<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Locale extends Model
{
    //
    /** @use HasFactory<\Database\Factories\LocaleFactory> */
    use SoftDeletes, HasFactory;
    protected $guarded = [];
    protected $table = 'locales';
}
