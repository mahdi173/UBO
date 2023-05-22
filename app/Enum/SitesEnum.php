<?php

namespace App\Enum;

enum SitesEnum
{
    public const MYSTERYBLOG = 'mysteryblog.com';
    public const UBOLARACAST = 'ubolaracast.com';
    
    /**
     * Get all available site domains.
     *
     * @return array
     */
    public static function all(): array
    {
        return [
            self::MYSTERYBLOG,
            self::UBOLARACAST
        ];
    }
}
