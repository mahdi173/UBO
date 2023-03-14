<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WpSite extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function pole(){
        return $this->belongsTo(Pole::class);
    }

    function wpUserSiteRole() {
        return $this->hasMany(WpUserSiteRole::class);
    }
}
