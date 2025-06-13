<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaySlip extends Model
{
    //
    /** @use HasFactory<\Database\Factories\PaySlipFactory> */
    use SoftDeletes, HasFactory;
    protected $guarded = [];
    protected $table   = 'pay_slips';

    /**
     * Get the user that owns the PaySlip
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
