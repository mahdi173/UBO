<?php

namespace App\Filters;

class DeletedAtFilter
{
    function __invoke($query, $date)
    {
        return  $query->where('deleted_at', 'LIKE', '%'.$date.'%');
       
    }
}