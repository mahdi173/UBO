<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Log extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'user_name',
        'action',
        'status',
        'json_detail'
    ];

    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }

     /**
     * scopeFilter
     *
     * @param  mixed $query
     * @param  ?array $filters
     * @param  ?array $sort
     * @return void
     */
    public function scopeFilter($query, ?array $filters, ?array $sort)
    {
        if(is_array($filters)){
            foreach ($filters as $filter => $value) {
                switch ($filter) {
                    case 'user_id':
                        $query->where('user_id',$value);
                        break;
                    case 'user_name':
                        $query->where(DB::raw('lower(user_name)'), 'like', '%'.strtolower($value).'%');
                        break;
                    case 'action':
                        $query->where(DB::raw('lower(action)'), 'like', '%'.strtolower($value).'%');
                        break;
                    case 'status':
                        $query->where(DB::raw('lower(status)'), 'like', '%'.strtolower($value).'%');
                        break;
                    case 'created_at':
                        $query->where('created_at', 'like', '%'.$value.'%');
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
                       'user_id' => $query->orderBy($field , !empty($direction) ? $direction : 'ASC'),
                       'user_name' => $query->orderBy($field , !empty($direction) ? $direction : 'ASC'),
                       'action' => $query->orderBy($field ,!empty($direction) ? $direction : 'ASC'),
                       'status' => $query->orderBy($field , !empty($direction) ? $direction : 'ASC'),
                       'created_at' => $query->orderBy($field , !empty($direction) ? $direction : 'ASC'),
                       default => $query,
                   };
               }
           );
        }
        
        return $query;
    }
}
