<?php

namespace App\Filters;

class UserNameFilter
{
    function __invoke($query, $userName)
    {
        return  $query->where('userName', 'LIKE', '%'.$userName.'%');
       
    }
}