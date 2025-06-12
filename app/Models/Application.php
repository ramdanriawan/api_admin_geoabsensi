<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    //

    use SoftDeletes;
    protected $guarded = [];
    protected $table   = 'applications';

    public function platforms() {
        return $this->hasMany(Platform::class);
    }

    public function locales() {
        return $this->hasMany(Locale::class);
    }


}
