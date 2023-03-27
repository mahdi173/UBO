<?php

namespace App\Filters;

class LastNameFilter
{
    function __invoke($query, $lastName)
    {
        return  $query->where('lastName', 'LIKE', '%'.$lastName.'%');
       
    }
}