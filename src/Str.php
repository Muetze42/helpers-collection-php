<?php

namespace NormanHuth\Helpers;

use Illuminate\Support\Str as BaseStr;

class Str extends BaseStr
{
    /**
     * Get excerpt of a string
     *
     * @param string      $text
     * @param int         $limit
     * @param string|null $excerpt
     * @param string      $end
     * @return string
     * @deprecated
     */
    public static function getExcerpt(string $text, int $limit = 100, ?string $excerpt = null, string $end = '...'): string
    {
        $string = strip_tags($text);

        if (strlen($text) <= $limit) {
            return $text;
        }

        if ($excerpt) {
            return self::getExcerpt($excerpt);
        }

        $limit = $limit - strlen($end);

        $string = wordwrap($string, $limit);
        $parts = explode("\n", $string);

        return $parts[0].$end;
    }

    /**
     * Add whitespace before every upper char
     *
     * @param string $string
     * @return string
     */
    public static function spaceBeforeCapitals(string $string): string
    {
        return trim(preg_replace('/(?<! )[A-Z]/', ' $0', $string));
    }

    /**
     * Generate a URL friendly "slug" from a given string.
     *
     * @param string                $title
     * @param string                $separator
     * @param string|null           $language
     * @param array<string, string> $dictionary
     * @return string
     */
    public static function slug($title, $separator = '-', $language = 'en', $dictionary = ['@' => 'at']): string
    {
        if (!$language && class_exists('Illuminate\Foundation\Application') &&
            class_exists('Illuminate\Support\Facades\App') &&
            method_exists('Illuminate\Support\Facades\App', 'getLocale')) {
            $language = \Illuminate\Support\Facades\App::getLocale();
        }

        $language = in_array($language, ['en', 'de', 'bg']) ? $language : 'en';

        return parent::slug($title, $separator, $language, $dictionary);
    }

    /**
     * Remove non ASCII characters from a string
     *
     * @param string $string
     * @return string
     */
    public static function removeNonASCIICharacters(string $string): string
    {
        return trim(preg_replace('/[\x80-\xFF]/', '', $string));
    }

    /**
     * Domain with queries via `http_build_query`
     *
     * @param string $url
     * @param array  $params
     * @return string
     */
    public static function httpBuildQueryUrl(string $url, array $params = []): string
    {
        $url = rtrim($url, '?');
        $arg_separator = parse_url($url, PHP_URL_QUERY) ? '&' : '?';

        return $url.$arg_separator.Arr::query($params);
    }

    /**
     * Get index number of an integer
     *
     * @param int $int
     * @param int $steps
     * @return int
     */
    public static function indexNumber(int $int, int $steps = 100): int
    {
        return (int) (floor($int / $steps)) * $steps;
    }

    /**
     * Replace the last comma in a list with `and` word
     *
     * @param string|array $content
     * @param string       $word
     * @param string       $glue
     * @param string|null  $translateFunction
     * @return string
     */
    public static function lastAnd(string|array $content, string $word = 'and', string $glue = ', ', ?string $translateFunction = null): string
    {
        if (!is_array($content)) {
            $content = explode(',', $content);
            $content = array_map('trim', $content);
        }

        if (!$translateFunction && class_exists('Illuminate\Foundation\Application')) {
            $translateFunction = '__';
        }

        if ($translateFunction && function_exists($translateFunction)) {
            $word = call_user_func($translateFunction, $word);
        }

        return Arr::join($content, $glue, ' '.$word.' ');
    }

    /**
     * Return a random word by array of words
     *
     * @param array $words
     * @return string
     * @deprecated Use Arr::random
     */
    public static function randomWord(array $words): string
    {
        return $words[mt_rand(0, (count($words) - 1))];
    }

    /**
     * Generate a serial number
     * Example: YCY8N-DWCII-W63JY-A71PA-FTUMU
     *
     * @param bool   $toUpper
     * @param int    $parts
     * @param int    $partLength
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
     * @param int       $step
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
     * @param int      $digits
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

    /**
     * Returns the JSON representation pretty and unescaped of a value
     *
     * @param mixed $value
     * @return bool|string
     */
    public static function jsonPrettyEncode(mixed $value): bool|string
    {
        return json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Encode emojis to unicode
     *
     * @param $emoji
     * @return string
     */
    public static function emojiToUnicode($emoji): string
    {
        $emoji = mb_convert_encoding($emoji, 'UTF-32', 'UTF-8');

        return strtoupper(preg_replace("/^0+/", "U+", bin2hex($emoji)));
    }

    /**
     * Trim every line and remove doubled whitespaces and new lines
     *
     * @param string $string
     * @return string
     */
    public static function normalizeUserSubmit(string $string): string
    {
        $string = preg_replace('/^\h+|\h+$/m', '', $string);
        $string = preg_replace('/ {2,}/', ' ', $string);

        return preg_replace("/\n{3,}/", "\n", $string);
    }

    /**
     * Get Domain name from URL
     *
     * @param string $url
     * @return string
     */
    public static function getDomain(string $url): string
    {
        if (!str_contains($url, '://')) {
            $url = 'https://'.$url;
        }

        $pieces = parse_url($url);
        $domain = $pieces['host'] ?? '';
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z.]{2,6})$/i', $domain, $regs)) {
            return $regs['domain'];
        }

        return $domain;
    }
}
