<?php

namespace App\Interfaces;

use App\Models\WpSite;

interface WpSiteRepositoryInterface 
{
    public function showUsers(WpSite $site);
}