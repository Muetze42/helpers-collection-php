<?php

namespace NormanHuth\Helpers;

use ZipArchive;

/**
 * @deprecated Use \NormanHuth\Helpers\Str or \NormanHuth\Helpers\File
 */
class Tool
{
    /**
     * Replace the last comma in a list with `and` word
     *
     * @deprecated Use \NormanHuth\Helpers\Str::lastAnd
     * @param string|array $content
     * @param string       $word
     * @param string       $glue
     * @param string|null  $translateFunction
     * @return string
     */
    public static function lastAnd(string|array $content, string $word = 'and', string $glue = ',', ?string $translateFunction = null): string
    {
        return Str::lastAnd($content, $word, $glue, $translateFunction);
    }

    /**
     * Return a random word by array of words
     *
     * @deprecated Use \NormanHuth\Helpers\Str::randomWord
     * @param array $words
     * @return string
     */
    public static function randomWord(array $words): string
    {
        return Str::randomWord($words);
    }

    /**
     * Generate a serial number
     * Example: YCY8N-DWCII-W63JY-A71PA-FTUMU
     *
     * @deprecated Use \NormanHuth\Helpers\Str::generateSerialNo
     * @param bool   $toUpper
     * @param int    $parts
     * @param int    $partLength
     * @param string $separator
     * @return string
     */
    public static function generateSerialNo(bool $toUpper = true, int $parts = 5, int $partLength = 5, string $separator = '-'): string
    {
        return Str::generateSerialNo($toUpper, $parts, $partLength, $separator);
    }

    /**
     * Round up to the nearest multiple of `E`
     *
     * @deprecated Use \NormanHuth\Helpers\Str::ceilUpNearest
     * @param int|float $num
     * @param int       $step
     * @return float
     */
    public static function ceilUpNearest(int|float $num, int $step = 5): float
    {
        return Str::ceilUpNearest($num, $step);
    }

    /**
     * Format int with leading zeros
     *
     * @deprecated Use \NormanHuth\Helpers\Str::fillDigits
     * @param int|null $int $int = 5
     * @param int      $digits
     * @return string|null
     */
    public static function fillDigits(?int $int, int $digits = 5): ?string
    {
        return Str::fillDigits($int, $digits);
    }

    /**
     * Get a random HEX color
     *
     * @deprecated Use \NormanHuth\Helpers\Str::randomHexColor
     * @return string
     */
    public static function randomHexColor(): string
    {
        return Str::randomHexColor();
    }

    /**
     * Get a part of a HEX color
     *
     * @deprecated Use \NormanHuth\Helpers\Str::randomHexColorPart
     * @return string
     */
    public static function randomHexColorPart(): string
    {
        return Str::randomHexColorPart();
    }

    /**
     * Create a file archive inclusive files in directories, compressed with Zip
     *
     * @deprecated Use \NormanHuth\Helpers\File::zipDirectory
     * @param string   $target
     * @param string   $source
     * @param bool     $overwriteArchive
     * @param int|null $flags
     * @return bool
     */
    public static function zipDirectory(string $target, string $source, bool $overwriteArchive = false, ?int $flags = null): bool
    {
        return File::zipDirectory($target, $source, $overwriteArchive, $flags);
    }

    /**
     * Extract Zip archive contents
     *
     * @deprecated Use \NormanHuth\Helpers\File::unzip
     * @param string $source
     * @param string $target
     * @return bool
     */
    public static function unzip(string $source, string $target): bool
    {
        return File::unzip($source, $target);
    }
}
