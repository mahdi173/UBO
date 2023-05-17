<?php
namespace App\Enum;

enum ActionsEnum:string
{
    case CREATE = 'Created';
    case UPDATE = 'Updated';
    case DELETE = 'Deleted';
    case FETCH = 'Fetched';

}