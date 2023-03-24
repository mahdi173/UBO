<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
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
     * wpSites
     *
     * @return void
     */
    public function wpSites(){
        return $this->hasMany(WpSite::class);
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
<<<<<<< HEAD
    public function scopeFilter($query, array $filters){
=======
    public function scopeFilter($query, array $filters ,$sortBy = 'id', $sortDirection = 'asc'){
>>>>>>> main
        if($filters['name']  ?? false){
            $query
                ->where('name', 'like', '%' . trim($filters['name']) . '%');
        }
        if($filters['id']  ?? false){
            $query
                ->where('id', 'like', '%' . trim($filters['id']) . '%');
        }
        if($filters['createdat']  ?? false){
            $query
                ->where('created_at', 'like', '%' . trim($filters['createdat']). '%');
        }
        if($filters['updatedat']  ?? false){
            $query
                ->where('updated_at', 'like', '%' . trim($filters['updatedat']). '%');
        }
        if($filters['deletedat']  ?? false){
            $query
                ->where('deleted_at', 'like', '%' . trim($filters['deletedat']). '%');
        }
<<<<<<< HEAD
=======
        $query->orderBy($sortBy, $sortDirection);
>>>>>>> main
    }
}
