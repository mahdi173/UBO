<?php

namespace App\Filters;

class NameFilter
{
    function __invoke($query, $name)
    {
        return  $query->where('name', 'LIKE', '%'.$name.'%');
    }
}