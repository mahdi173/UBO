<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class WpUser extends Model
{
    use HasFactory, SoftDeletes;
    
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
<<<<<<< HEAD
<<<<<<< HEAD
        'userName',
        'firstName',
        'lastName',
=======
        'username',
        'firstname',
        'lastname',
>>>>>>> 9853fe6 ([tr - wpk-training/2345] Media - Pre Embauche - PFE 2023 - UBO - Réalisation - Back - CRUD (pole,role,type)+filter)
=======
        'username',
        'firstname',
        'lastname',
>>>>>>> main
        'email',
        'password'
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
