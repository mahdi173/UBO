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
<<<<<<< HEAD
        'pole_id',
        'type_id'
=======
    
       

>>>>>>> main
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
     * logs
     *
     * @return MorphMany
     */
    public function logs(): MorphMany
    {
        return $this->morphMany(Log::class, 'loggable');
    }
}
