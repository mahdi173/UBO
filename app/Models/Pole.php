<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pole extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
    
    public function wpSites(){
        return $this->hasMany(WpSite::class);
    }
}
