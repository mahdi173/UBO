<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WpUserSiteRole extends Model
{
    use HasFactory;

    function wpUser() {
        return $this->belongsToMany(WpUser::class);
     }
     
     function wpSite() {
        return $this->belongsToMany(WpSite::class);
     }
     
     function wpRole() {
        return $this->belongsToMany(WpRole::class);
     }
}
