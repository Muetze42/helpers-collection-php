<?php

namespace NormanHuth\Helpers;

/**
 * @deprecated
 */
class Url
{
    /**
     * Get Domain name from URL
     *
     * @deprecated Use \NormanHuth\Helpers\Str::getDomain
     * @param string $url
     * @return string
     */
    public static function getDomain(string $url): string
    {
        return Str::getDomain($url);
    }
}
