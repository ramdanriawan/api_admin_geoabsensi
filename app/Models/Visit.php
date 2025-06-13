<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{
    //
    /** @use HasFactory<\Database\Factories\VisitFactory> */
    use SoftDeletes, HasFactory;
    protected $guarded = [];
    protected $table   = 'visits';

    /**
     * Get the user that owns the Visit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the visit_type that owns the Visit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visit_type(): BelongsTo
    {
        return $this->belongsTo(VisitType::class);
    }
}
