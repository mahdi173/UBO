<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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
    
    protected $hidden = ['pole_id', 'type_id'];

    /**
     * type
     *
     * @return void
     */
    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function users()
    {
        return $this->belongsToMany(WpUser::class, 'user_site')
                    ->withPivot(['roles', 'username'])
                    ->wherePivotNull('deleted_at');
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
                    case 'name':
                        $query->where(DB::raw('lower(name)'),'like','%'.strtolower($value).'%');
                        break;
                    case 'domain':
                        $query->where(DB::raw('lower(domain)'),'like','%'.strtolower($value).'%');
                        break;
                    case 'pole':
                        $query->whereHas("pole", function ($query) use ($value) {
                            $query->where(DB::raw('LOWER(name)'), 'LIKE', '%'. strtolower($value).'%');
                        });
                        break;
                    case 'type':
                        $query->whereHas("type", function ($query) use ($value) {
                            $query->where(DB::raw('LOWER(name)'), 'LIKE', '%'. strtolower($value).'%');
                        });                        
                        break;
                    case 'created_at':
                        $query->where('created_at', 'like', '%'. $value.'%');
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
                       'name' => $query->orderBy($field , !empty($direction) ? $direction : 'ASC'),
                       'domain' => $query->orderBy($field , !empty($direction) ? $direction : 'ASC'),
                       'pole_id' => $query->orderBy($field , !empty($direction) ? $direction : 'ASC'),
                       'type_id' => $query->orderBy($field , !empty($direction) ? $direction : 'ASC'),
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
