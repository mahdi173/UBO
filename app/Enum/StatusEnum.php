<?php
namespace App\Enum;

enum StatusEnum:string
{
    case SUCCESS = 'Success';
    case WARNING = 'Warning';
    case DANGER = 'Fatal Error';
}