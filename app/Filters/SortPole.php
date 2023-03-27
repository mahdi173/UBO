<?php

namespace App\Filters;

class SortPole
{
    function __invoke($query, $order)
    {
        //return $query->whereHas('pole')->orderBy("name", $order);
        return $query->orderBy('pole_id', $order);
    }
}