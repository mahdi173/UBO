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

    public function scopeFilter($query, $filters, $paginate,  array|string $sorts="id", array|string $orders="asc")
    {
        foreach ($filters as $filter => $value) {
            if($filter=="pole" || $filter=="type")
            {
                $query= $query->whereHas($filter, function ($query) use ($value) {
                    $query->where('name', 'LIKE', '%'.$value.'%');
                });
            }else{
                $query= $query->where($filter, 'LIKE', '%'. $value.'%');
            }
        }

        if(is_array($sorts)){
            for($i=0; $i<sizeof($sorts); $i++){
                if($sorts[$i]=="pole"){
                    $query= $query->orderBy("pole_id", $orders[$i]);
                }else if($sorts[$i]=="type"){
                    $query= $query->orderBy("type_id", $orders[$i]);
                }else{
                    $query= $query->orderBy($sorts[$i], $orders[$i]);
                }                
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
