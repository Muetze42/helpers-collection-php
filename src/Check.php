<?php

namespace NormanHuth\Helpers;

/**
 * @deprecated Remove future versions
 */
class Check
{
    /**
     * Check if a string is in JSON-Format
     *
     * @deprecated Remove future versions. Use Str::isJson instead
     *
     * @param string $value
     * @return bool
     */
    public static function isJson(string $value): bool
    {
        return \Illuminate\Support\Str::isJson($value);
    }
}
