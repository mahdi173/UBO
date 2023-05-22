<?php
namespace App\Enum;

enum WpEndpointsEnum:string
{
    case USERS = '/wp-json/wp/v2/wp-users';
}