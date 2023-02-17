<?php

namespace NormanHuth\Helpers;

use Illuminate\Support\Arr as BaseArr;

class Arr extends BaseArr
{
    /**
     * Remove null or optional empty entries from array
     *
     * @param array $array
     * @param bool  $removeEmptyValues
     * @return array
     */
    public static function clean(array $array, bool $removeEmptyValues = false): array
    {
        return array_filter($array, function ($value) {
            return !is_null($value);
        });
    }

    /**
     * Array map on array keys
     *
     * @param callable $callback
     * @param array    $array
     * @return array
     */
    public static function keyMap(callable $callback, array $array): array
    {
        array_walk($array, function ($value, $key) use (&$return, $callback) {
            $return[call_user_func($callback, $key)] = $value;
        });

        return $return;
    }

    /**
     * Replace every null value with empty string in an array
     *
     * @param $value
     * @return void
     */
    public static function replaceNullValueWithEmptyString(&$value): void
    {
        $value = $value === null ? '' : $value;
    }
}
