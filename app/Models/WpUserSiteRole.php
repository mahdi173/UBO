<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class WpUserSiteRole extends Model
{
    use HasFactory, SoftDeletes;
   


    public function wpUser() {
        return $this->belongsToMany(WpUser::class);
     }
     
     public function wpSite() {
        return $this->belongsToMany(WpSite::class);
     }
     
     public function wpRole() {
        return $this->belongsToMany(WpRole::class);
     }

     public function logs(): MorphMany{
        return $this->morphMany(Log::class, 'loggable');
     }
}
