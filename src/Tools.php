<?php

namespace NormanHuth\Helpers;

use Illuminate\Support\Str;

class Tools
{
    /**
     * Replace the last comma in a list with `and` word
     *
     * @param string|array $content
     * @param string $word
     * @param string $glue
     * @param string|null $translateFunction
     * @return string
     */
    public static function lastAnd(string|array $content, string $word = 'and', string $glue = ',', ?string $translateFunction = null): string
    {
        if (is_array($content)) {
            $content = implode(', ', $content);
        }

        if (!str_contains($content, ',')) {
            return $content;
        }

        if (!$translateFunction && class_exists('Illuminate\Foundation\Application')) {
            $translateFunction = '__';
        }

        if ($translateFunction && function_exists($translateFunction)) {
            $word = call_user_func($translateFunction, $word);
        }

        return substr_replace($content, ' '.$word, strrpos($content, $glue), 1);
    }

    /**
     * Return a random word by array of words
     *
     * @param array $words
     * @return string
     */
    public static function randomWord(array $words): string
    {
        return $words[mt_rand(0, (count($words) - 1))];
    }

    /**
     * Generate a serial number
     * Example: YCY8N-DWCII-W63JY-A71PA-FTUMU
     *
     * @param bool $toUpper
     * @param int $parts
     * @param int $partLength
     * @param string $separator
     * @return string
     */
    public static function generateSerialNo(bool $toUpper = true, int $parts = 5, int $partLength = 5, string $separator = '-'): string
    {
        $keyParts = [];
        for ($i = 1; $i <= $parts; $i++) {
            $keyParts[] = Str::random($partLength);
        }

        $key = implode($separator, $keyParts);

        return $toUpper ? Str::upper($key) : $key;
    }

    /**
     * Round up to the nearest multiple of `E`
     *
     * @param int|float $num
     * @param int $step
     * @return float
     */
    public static function ceilUpNearest(int|float $num, int $step = 5): float
    {
        if (round($step) != $step) {
            $step = round($step);
        }

        if ($step < 0) {
            $step = 1;
        }

        return ceil($num / $step) * $step;
    }

    /**
     * Format int with leading zeros
     *
     * @param int|null $int $int = 5
     * @param int $digits
     * @return string|null
     */
    public static function fillDigits(?int $int, int $digits = 5): ?string
    {
        if ($int > 0) {
            return sprintf('%0'.$digits.'d', $int);
        }

        return null;
    }

    /**
     * Get a random HEX color
     *
     * @return string
     */
    public static function randomHexColor(): string
    {
        return static::randomHexColorPart().static::randomHexColorPart().static::randomHexColorPart();
    }

    /**
     * Get a part of a HEX color
     *
     * @return string
     */
    public static function randomHexColorPart(): string
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }
}
