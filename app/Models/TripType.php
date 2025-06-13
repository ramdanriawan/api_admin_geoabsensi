<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TripType extends Model
{
    //
    /** @use HasFactory<\Database\Factories\TripTypeFactory> */
    use SoftDeletes, HasFactory;
    protected $guarded = [];
    protected $table = 'trip_types';

    /**
     * Get all of the trips for the TripType
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
}
