<?php

namespace App\Filters;

class UpdatedAtFilter
{
    function __invoke($query, $date)
    {
        return  $query->where('updated_at', 'LIKE', '%'.$date.'%');
       
    }
}