<?php

use NormanHuth\Helpers\Arr;
use NormanHuth\Helpers\Check;
use NormanHuth\Helpers\File;
use NormanHuth\Helpers\Image;
use NormanHuth\Helpers\Str;
use NormanHuth\Helpers\Tools;
use NormanHuth\Helpers\Url;

if (!function_exists('arrayClean')) {
    /**
     * Remove null or optional empty entries from array
     *
     * @param array $array
     * @param bool $removeEmptyValues
     * @return array
     */
    function arrayClear(array $array, bool $removeEmptyValues = false): array
    {
        return array_filter($array, function ($value) use ($removeEmptyValues) {
            if ($removeEmptyValues) {
                return !empty($value);
            }

            return !is_null($value);
        });
    }
}

if (!function_exists('arrayKeyMap')) {
    /**
     * Array map on array keys
     *
     * @param callable $callback
     * @param array $array
     * @return array
     */
    function arrayKeyMap(callable $callback, array $array): array
    {
        return Arr::keyMap($callback, $array);
    }
}

if (!function_exists('strSpaceBeforeCapitals')) {
    /**
     * Add whitespace before every upper char
     *
     * @param string $string
     * @return string
     */
    function strSpaceBeforeCapitals(string $string): string
    {
        return Str::spaceBeforeCapitals($string);
    }
}

if (!function_exists('randomWord')) {
    /**
     * Return a random word by array of words
     *
     * @param array $words
     * @return string
     */
    function randomWord(array $words): string
    {
        return Tools::randomWord($words);
    }
}

if (!function_exists('arrayReplaceNullValueWithEmptyString')) {
    /**
     * Replace every null value with empty string in an array
     *
     * @param $value
     * @return void
     */
    function arrayReplaceNullValueWithEmptyString(&$value): void
    {
        Arr::replaceNullValueWithEmptyString($value);
    }
}

if (!function_exists('fileGetExtension')) {
    /**
     * Get file extension from a file path
     *
     * @param string $path
     * @return string
     */
    function fileGetExtension(string $path): string
    {
        return File::getExtension($path);
    }
}

if (!function_exists('fileGetFilename')) {
    /**
     * Get filename from a file path
     *
     * @param string $path
     * @return string
     */
    function fileGetFilename(string $path): string
    {
        return File::getFilename($path);
    }
}

if (!function_exists('lastAnd')) {
    /**
     * Replace the last comma in a list with `and`
     *
     * @param string|array $content
     * @param string $word
     * @param string $glue
     * @param string|null $translateFunction
     * @return string
     */
    function lastAnd(string|array $content, string $word = 'and', string $glue = ',', ?string $translateFunction = null): string
    {
        return Tools::lastAnd($content, $word, $glue, $translateFunction);
    }
}

if (!function_exists('generateSerialNo')) {
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
    function generateSerialNo(bool $toUpper = true, int $parts = 5, int $partLength = 5, string $separator = '-'): string
    {
        return Tools::generateSerialNo($toUpper, $parts, $partLength, $separator);
    }
}

if (!function_exists('dataGetByJsonFile')) {
    /**
     * Get data key by JSON file
     *
     * @param string $file
     * @param array|int|string|null $key
     * @param mixed $default
     * @return array|mixed
     */
    function dataGetByJsonFile(string $file, array|int|string|null $key = null, mixed $default = null): mixed
    {
        return File::dataGetByJsonFile($file, $key, $default);
    }
}

if (!function_exists('strSlug')) {
    /**
     * Generate a URL friendly "slug" from a given string.
     *
     * @param string $title
     * @param string $separator
     * @param string|null $language
     * @param string[] $dictionary
     * @return string
     */
    function strSlug(string $title, string $separator = '-', ?string $language = null, array $dictionary = ['@' => 'at']): string
    {
        return Str::slug($title, $separator, $language, $dictionary);
    }
}

if (!function_exists('urlGetDomain')) {
    /**
     * Get Domain name from URL
     *
     * @param string $url
     * @return string
     */
    function urlGetDomain(string $url): string
    {
        return Url::getDomain($url);
    }
}

if (!function_exists('ceilUpNearest')) {
    /**
     * Round up to the nearest multiple of `E`
     *
     * @param int|float $num
     * @param int $step
     * @return float
     */
    function ceilUpNearest(int|float $num, int $step = 5): float
    {
        return Tools::ceilUpNearest($num, $step);
    }
}

if (!function_exists('fillDigits')) {
    /**
     * Format int with leading zeros
     *
     * @param int|null $int $int = 5
     * @param int $digits
     * @return string|null
     */
    function fillDigits(?int $int, int $digits = 5): ?string
    {
        return Tools::fillDigits($int, $digits);
    }
}

if (!function_exists('isJson')) {
    function isJson(string $data): bool
    {
        return Check::isJson($data);
    }
}

if (!function_exists('randomHexColor')) {
    /**
     * Get a random HEX color
     *
     * @return string
     */
    function randomHexColor(): string
    {
        return Tools::randomHexColor();
    }
}

if (!function_exists('randomHexColorPart')) {
    /**
     * Get a part of a HEX color
     *
     * @return string
     */
    function randomHexColorPart(): string
    {
        return Tools::randomHexColorPart();
    }
}

if (!function_exists('imageIsPortrait')) {
    /**
     * Check if an image is in portrait format
     *
     * @param string $file
     * @return bool
     */
    function isPortrait(string $file): bool
    {
        return Image::isPortrait($file);
    }
}

if (!function_exists('httpBuildQueryUrl')) {
    /**
     * Domain with queries via `http_build_query`
     *
     * @param string $url
     * @param array $params
     * @return string
     */
    function httpBuildQueryUrl(string $url, array $params = []): string
    {
        return Str::httpBuildQueryUrl($url, $params);
    }
}

if (function_exists('strRemoveNonASCIICharacters')) {
    /**
     * Remove non ASCII characters from a string
     *
     * @param string $string
     * @return string
     */
    function strRemoveNonASCIICharacters(string $string): string
    {
        return Str::removeNonASCIICharacters($string);
    }
}

if (!function_exists('toolGenerateSerialNo')) {
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
    function toolGenerateSerialNo(bool $toUpper = true, int $parts = 5, int $partLength = 5, string $separator = '-'): string
    {
        return Tools::generateSerialNo($toUpper, $parts, $partLength, $separator);
    }
}

if (!function_exists('strExcerpt')) {
    /**
     * Get excerpt of a string
     *
     * @param string $text
     * @param int $limit
     * @param string|null $excerpt
     * @param string $end
     * @return string
     */
    function strExcerpt(string $text, int $limit = 100, ?string $excerpt = null, string $end = '...'): string
    {
        return Str::getExcerpt($text, $limit, $excerpt, $end);
    }
}

if (!function_exists('indexNumber')) {
    /**
     * Get index number of an integer
     *
     * @param int $int
     * @param int $steps
     * @return int
     */
    function indexNumber(int $int, int $steps = 100): int
    {
        return Str::indexNumber($int, $steps);
    }
}

if (!function_exists('paresMarkdown')) {
    /**
     * Parse the given Markdown text string into HTML.
     *
     * @param string $string
     * @return string
     */
    function paresMarkdown(string $string): string
    {
        return Str::markdown($string);
    }
}

if (!function_exists('jsonPrettyEncode')) {
    /**
     * @param mixed $value
     * @return bool|string
     */
    function jsonPrettyEncode(mixed $value): bool|string
    {
        return json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
