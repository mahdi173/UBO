<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class WpUser extends Model
{
    use HasFactory, SoftDeletes;
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'userName',
        'firstName',
        'lastName',
        'email'
    ];
    
    protected $casts = [
        'roles' => 'array',
    ];

    
    /**
     * hidden
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
        
    /**
     * sites
     *
     */
    public function sites()
    {
        return $this->belongsToMany(WpSite::class, 'user_site')
                    ->withPivot(['roles', 'username'])
                    ->wherePivotNull('deleted_at');
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

    public function scopeFilter($query, ?array $filters, ?array $sort, $paginate)
    {
        if(is_array($filters)){
            foreach ($filters as $filter => $value) {
                switch ($filter) {
                    case 'id':
                        $query->where('id',$value);
                        break;
                    case 'userName':
                        $query->where(DB::raw('lower(userName)'), 'like', '%'.strtolower($value).'%');
                        break;
                    case 'firstName':
                        $query->where(DB::raw('lower(firstName)'), 'like', '%'.strtolower($value).'%');
                        break;
                    case 'lastName':
                        $query->where(DB::raw('lower(lastName)'), 'like', '%'.strtolower($value).'%');
                        break;
                    case 'email':
                        $query->where(DB::raw('lower(email)'), 'like', '%'.strtolower($value).'%');
                        break;
                    case 'created_at':
                        $query->where('created_at', 'like', '%'.$value.'%');
                        break;
                    case 'updated_at':
                        $query->where('updated_at', 'like', '%'.$value.'%');
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
                       'userName' => $query->orderBy($field , !empty($direction) ? $direction : 'ASC'),
                       'firstName' => $query->orderBy($field ,!empty($direction) ? $direction : 'ASC'),
                       'lastName' => $query->orderBy($field , !empty($direction) ? $direction : 'ASC'),
                       'email' => $query->orderBy($field , !empty($direction) ? $direction : 'ASC'),
                       'created_at' => $query->orderBy($field , !empty($direction) ? $direction : 'ASC'),
                       'updated_at' => $query->orderBy($field , !empty($direction) ? $direction : 'ASC'),
                       default => $query,
                   };
               }
           );
        }

        if($paginate){
            $query=  $query->paginate($paginate);
        }

        return $query;
    }
}
