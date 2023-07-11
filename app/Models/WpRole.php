<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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
       /**
    * getCreatedAtAttribute
    *
    * @param  mixed $value
    * @return void
    */
   public function getCreatedAtAttribute($value)
   {
       return date('Y-m-d H:m:s', strtotime($value));
   }
   
   /**
    * getUpdatedAtAttribute
    *
    * @param  mixed $value
    * @return void
    */
   public function getUpdatedAtAttribute($value)
   {
       return date('Y-m-d H:m:s ', strtotime($value));
   }   
   /**
    * getDeletedAtAttribute
    *
    * @param  mixed $value
    * @return void
    */
   public function getDeletedAtAttribute($value)
   {
       if(!is_null($value)){
        return date('Y-m-d H:m:s ', strtotime($value));
       }
   }
    /**
     * scopeFilter
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @param  mixed $sort
     * @return mixed
     */
    public function scopeFilter($query, ?array $filters, ?array $sort)
    {
        if(is_array($filters)){
            foreach ($filters as $filter => $value) {
                switch ($filter) {
                    case 'id':
                        $query->where('id',$value);
                        break;
                    case 'name':
                        $query->where(DB::raw('lower(name)'), 'like', '%'.strtolower($value).'%');
                        break;
                    case 'created_at':
                        $query->where('created_at', 'like', '%'. $value.'%');
                        break;
                    case 'updated_at':
                        $query->where('updated_at', 'like', '%'.  $value.'%');
                        break;
                    default:
                        $query;
                        break;
                }
            }
        }

        if(is_array($sort)) {
            // Get key and value
            $field = key($sort);
            $direction = reset($sort);
            // Run the query based on the field and value 
            // Default return $query without orderBy clause
            $query->when(
                $field,
                static function ($query, $field) use ($direction): void {
                   match($field) {
                       'id' => $query->orderBy($field , !empty($direction) ? $direction : 'ASC'),
                       'name' => $query->orderBy($field , !empty($direction) ? $direction : 'ASC'),
                       'created_at' => $query->orderBy($field , !empty($direction) ? $direction : 'ASC'),
                       'updated_at' => $query->orderBy($field , !empty($direction) ? $direction : 'ASC'),
                       default => $query,
                   };
               }
           );
        }
        
        return $query;
    }
}
