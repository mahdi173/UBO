<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSite extends Pivot
{
    use SoftDeletes;

    protected $table = 'user_site';

    public function user()
    {
        return $this->belongsTo(WpUser::class);
    }

    public function site()
    {
        return $this->belongsTo(WpSite::class);
    }
}
