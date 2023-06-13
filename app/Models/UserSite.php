<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSite extends Pivot
{
    use SoftDeletes;

    protected $table = 'user_site';

    public function user()
    {
        return $this->belongsTo(WpUser::class, 'wp_user_id');
    }

    public function site()
    {
        return $this->belongsTo(WpSite::class, 'wp_site_id');
    }

    /**
     * logs
     *
     * @return MorphMany
     */
    public function logs(): MorphMany
    {
        return $this->morphMany(Log::class, 'loggable');
    }
}