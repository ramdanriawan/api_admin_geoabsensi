<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitType extends Model
{
    //
    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'visit_types';

    public function visits()
    {
        return $this->hasMany(Visit::class, );
    }

}
