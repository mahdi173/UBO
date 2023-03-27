<?php

namespace App\Filters;

class PoleFilter
{
    function __invoke($query, $name)
    {
        return $query->whereHas('pole', function ($query) use ($name) {
            $query->where('name', 'LIKE', '%'.$name.'%');
        });
    }
}