<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WpRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    function wpUserSiteRole() {
        return $this->hasMany(WpUserSiteRole::class);
     }
}
