<?php

namespace App\Filters;

class PaginateFilter
{
    function __invoke($query, $number)
    {
        return  $query->paginate($number);
    }
}