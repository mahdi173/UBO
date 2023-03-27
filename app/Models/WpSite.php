<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class WpSite extends Model
{
    use HasFactory, SoftDeletes;
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'domain',
        'pole_id',
        'type_id'
    ];
    
    /**
     * type
     *
     * @return void
     */
    public function type(){
        return $this->belongsTo(Type::class);
    }
    
    /**
     * pole
     *
     * @return void
     */
    public function pole(){
        return $this->belongsTo(Pole::class);
    }
    
    /**
     * wpUserSiteRole
     *
     * @return void
     */
    public function wpUserSiteRole() {
        return $this->hasMany(WpUserSiteRole::class);
    }
    
    /**
     * roles
     *
     * @return void
     */
    public function roles() {
        return $this->belongsToMany(WpRole::class, 'wp_user_site_roles');
    }
    
    /**
     * users
     *
     * @return void
     */
    public function users() {
        return $this->belongsToMany(WpUser::class, 'wp_user_site_roles');
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

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
