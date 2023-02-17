<?php

namespace NormanHuth\Helpers;

class File
{
    /**
     * Get file extension from a file path
     *
     * @param string $path
     * @return string
     */
    public static function getExtension(string $path): string
    {
        return pathinfo($path, PATHINFO_EXTENSION);
    }

    /**
     * Get filename from a file path
     *
     * @param string $path
     * @return string
     */
    public static function getFilename(string $path): string
    {
        return pathinfo($path, PATHINFO_FILENAME);
    }

    /**
     * Get data key by JSON file
     *
     * @param string                $file
     * @param array|int|string|null $key
     * @param mixed                 $default
     * @return array|mixed
     */
    public static function dataGetByJsonFile(string $file, array|int|string|null $key = null, mixed $default = null): mixed
    {
        $target = json_decode(file_get_contents($file), true);

        return data_get($target, $key, $default);
    }
}
