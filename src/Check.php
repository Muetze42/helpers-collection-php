<?php

namespace NormanHuth\Helpers;

class Check
{
    /**
     * Check if a string is in JSON-Format
     *
     * @param string $data
     * @return bool
     */
    public static function isJson(string $data): bool
    {
        $data = json_decode($data, true);

        if (json_last_error() !== JSON_ERROR_NONE || empty($data)) {
            return false;
        }

        return true;
    }
}
