<?php

namespace App\Filters;

class CreatedAtFilter
{
    function __invoke($query, $date)
    {
        return  $query->where('created_at', 'LIKE', '%'.$date.'%');
       
    }
}