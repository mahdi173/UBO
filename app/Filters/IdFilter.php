<?php

namespace App\Filters;

class IdFilter
{
    function __invoke($query, $id)
    {
        return  $query->where('id', $id);
    }
}