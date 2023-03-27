<?php

namespace App\Filters;

class SortFilter
{
    function __invoke($query, $sort, $order)
    {
        for($i=0; $i<sizeof($sort); $i++){
          $query= $query->orderBy($sort[$i], $order[$i]);
        }

        return  $query;
    }
}