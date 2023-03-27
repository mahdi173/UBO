<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class WpRole extends Model
{
    use HasFactory, SoftDeletes;
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
    
    /**
     * wpUserSiteRole
     *
     * @return void
     */
    public function wpUserSiteRole() {
        return $this->hasMany(WpUserSiteRole::class);
    }
    
    /**
     * sites
     *
     * @return void
     */
    public function sites() {
        return $this->belongsToMany(WpSite::class, 'wp_user_site_roles');
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

    public function scopeFilter($query, $filters, $paginate, array|string $sorts="id", array|string $orders="asc")
    {
        foreach ($filters as $filter => $value) {
            $query= $query->where($filter, 'LIKE', '%'. $value.'%');
        }

        if(is_array($sorts)){
            for($i=0; $i<sizeof($sorts); $i++){
                $query= $query->orderBy($sorts[$i], $orders[$i]);
            }
        }else{
            $query= $query->orderBy($sorts, $orders);
        }

        if($paginate){
            $query=  $query->paginate($paginate);
        }

        return $query;
    }
}
