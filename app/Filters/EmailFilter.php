<?php

namespace App\Filters;

class EmailFilter
{
    function __invoke($query, $email)
    {
        return  $query->where('email', 'LIKE', '%'.$email.'%');
       
    }
}