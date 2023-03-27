<?php

namespace App\Filters;

class SortType
{
    function __invoke($query, $order)
    {
        //return $query->whereHas('type')->orderBy('id', $order);
        return $query->orderBy('type_id', $order);
    }
}