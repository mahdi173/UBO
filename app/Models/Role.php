<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
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
     * users
     *
     * @return void
     */
    public function users(){
        return $this->hasMany(User::class);
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
     * Method scopeFilters
     *
     * @param Builder $query 
     * @param ?array $filter
     * @param ?array $sort
     *
     * @return void
     */
    public function scopeFilters(
        Builder $query,
        ?array $filters,
        ?array $sort,
        $paginate
    ) {
        
        // Check if the filter is an array
        if(is_array($filters))
        {
             // Run the query based on the field and value
             foreach ($filters as $field => $searchFor) {
                switch ($field) {
                    case 'name':
                        $query->where(DB::raw('upper(name)'),'like','%'.strtoupper($searchFor).'%');
                        break;
                    case 'domain':
                        $query->where(DB::raw('upper(domain)'),'like','%'.strtoupper($searchFor).'%');
                        break;
                    case 'created_at':
                        $query->where('created_at', $searchFor);
                        break;
                    case 'updated_at':
                        $query->where('updated_at', $searchFor);
                        break;
                    default:
                        $query;
                        break;
                }
               
            }

        }
    
        // Check if the sort is an array
        if(is_array($sort)) {

            // Get key and value
            $field = key($sort);
            $direction = reset($sort);
            // Run the query based on the field and value 
            // Default return $query without orderBy clause
            $query->when(
                $field,
                static function (Builder $query, $field) use ($direction): void {
                   match($field) {
                       'name' => $query->orderBy($field , !empty($direction) ? $direction : 'ASC'),
                       'domain' => $query->orderBy($field ,!empty($direction) ? $direction : 'ASC'),
                       'created_at' => $query->orderBy($field , !empty($direction) ? $direction : 'ASC'),
                       'updated_at' => $query->orderBy($field , !empty($direction) ? $direction : 'ASC'),
                       default => $query,
                   };
               }
           );
        }
        if($paginate){
            $query= $query->paginate($paginate);
            }
        return $query;
    }
}
