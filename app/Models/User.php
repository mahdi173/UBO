<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'userName',
        'firstName',
        'lastName',
        'email',
        'password',
        'role_id',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /**
     * Role
     *
     * @return void
     */
    public function role(){
        return $this->belongsTo(Role::class);
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
        
        return $query;
    }

    /**
     * isAdmin
     *
     * @return bool
     */
    public function  isAdmin(): bool{
        if($this->role->name=="admin"){
            return true;
        }
        return false;
    }
}
