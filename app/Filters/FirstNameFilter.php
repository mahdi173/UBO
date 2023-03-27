<?php

namespace App\Filters;

class FirstNameFilter
{
    function __invoke($query, $firstName)
    {
        return  $query->where('firstName', 'LIKE', '%'.$firstName.'%');
    }
}