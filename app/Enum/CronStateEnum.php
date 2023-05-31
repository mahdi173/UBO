<?php
namespace App\Enum;

enum CronStateEnum:string
{
    case FETCH = 'Fetched';
    case ToDelete = 'todelete';
    case ToUpdate = 'update';
}