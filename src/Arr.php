<?php

namespace NormanHuth\Helpers;

use Illuminate\Support\Arr as BaseArr;
use NormanHuth\Helpers\Exception\FileNotFoundException;

class Arr extends BaseArr
{
    /**
     * Remove null or optional empty entries from array.
     *
     * @param array $array
     * @param bool  $removeEmptyValues
     * @return array
     */
    public static function clean(array $array, bool $removeEmptyValues = false): array
    {
        return array_filter($array, function ($value) use ($removeEmptyValues) {
            return !$removeEmptyValues ? !is_null($value) : !empty($value);
        });
    }

    /**
     * Applies the callback to the elements of the given array keys.
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
     * Replace every null value with empty string in an array.
     *
     * @param $value
     * @return void
     * @deprecated
     */
    public static function replaceNullValueWithEmptyString(&$value): void
    {
        $value = $value === null ? '' : $value;
    }

    /**
     * Decodes a JSON string from files and return merged array.
     *
     * @param array|string $files
     * @param bool         $throwFileNotFoundException
     * @throws FileNotFoundException
     * @return array
     */
    public static function fromJsonFiles(array|string $files, bool $throwFileNotFoundException = true): array
    {
        $returnArray = [];

        if (!is_array($files)) {
            $files = (array) $files;
        }

        foreach ($files as $file) {
            if (!file_exists($file)) {
                if ($throwFileNotFoundException) {
                    return throw new FileNotFoundException($file);
                }
                continue;
            }
            $returnArray = array_merge(
                $returnArray,
                json_decode(file_get_contents($file), true)
            );
        }

        return $returnArray;
    }

    /**
     * Add an array key value pair to specific position into an existing key value array.
     *
     * @param array  $array
     * @param string $key
     * @param mixed  $value
     * @param int    $position
     * @param bool   $insertAfter
     *
     * @return array
     */
    public static function keyValueInsertToPosition(array $array, string $key, mixed $value, int $position, bool $insertAfter = true): array
    {
        $results = [];
        $items = array_keys($array);

        foreach ($items as $index => $item) {
            if ($index == $position && !$insertAfter) {
                $results[$key] = $value;
            }

            $results[$item] = $array[$item];

            if ($index == $position && $insertAfter) {
                $results[$key] = $value;
            }
        }

        return $results;
    }
}
