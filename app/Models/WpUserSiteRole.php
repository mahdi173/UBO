<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class WpUserSiteRole extends Model
{
    use HasFactory, SoftDeletes;
   
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
      'wp_user_id',
      'wp_role_id',
      'wp_site_id'
    ];
    
    /**
     * wpUser
     *
     * @return void
     */
    public function wpUser() {
        return $this->belongsToMany(WpUser::class);
     }
          
     /**
      * wpSite
      *
      * @return void
      */
     public function wpSite() {
        return $this->belongsToMany(WpSite::class);
     }
          
     /**
      * wpRole
      *
      * @return void
      */
     public function wpRole() {
        return $this->belongsToMany(WpRole::class);
     }
     
     /**
      * logs
      *
      * @return MorphMany
      */
     public function logs(): MorphMany{
        return $this->morphMany(Log::class, 'loggable');
     }
}
