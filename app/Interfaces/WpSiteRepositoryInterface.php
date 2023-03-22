<?php

namespace App\Interfaces;

interface WpSiteRepositoryInterface 
{
    public function getAllWpSites();
    public function createWpSite(array $data);
}