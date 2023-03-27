<?php

namespace App\Filters;

class TypeFilter
{
    function __invoke($query, $name)
    {
        return $query->whereHas('type', function ($query) use ($name) {
            $query->where('name', 'LIKE', '%'.$name.'%');
        });
    }
}