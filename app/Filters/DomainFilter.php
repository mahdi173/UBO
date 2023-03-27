<?php

namespace App\Filters;

class DomainFilter
{
    function __invoke($query, $domain)
    {
        return  $query->where('domain', 'LIKE', '%'.$domain.'%');  
    }
}