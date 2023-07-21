<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use NormanHuth\Helpers\Arr;
use NormanHuth\Helpers\File;
use NormanHuth\Helpers\Image;
use NormanHuth\Helpers\Str;

if (!class_exists('Illuminate\Foundation\Application')) {
    if (!function_exists('base_path')) {
        /**
         * Get the path to the base of the installation.
         *
         * @param string $path
         * @return string
         */
        function base_path(string $path = ''): string
        {
            if (!class_exists('\Composer\Autoload\ClassLoader')) {
                $basePath = dirname(__DIR__, 4);
            } else {
                $reflection = new ReflectionClass(\Composer\Autoload\ClassLoader::class);

                $basePath = dirname($reflection->getFileName(), 3);
            }

            return rtrim($basePath, '\\/').($path != '' ? DIRECTORY_SEPARATOR.ltrim($path, '\\/') : '');
        }
    }

    if (!function_exists('now')) {
        /**
         * Create a new Carbon instance for the current time.
         *
         * @param DateTimeZone|string|null $tz
         * @return Carbon
         */
        function now(DateTimeZone|string $tz = null): Carbon
        {
            return Date::now($tz);
        }
    }
}

/*
|--------------------------------------------------------------------------
| Array
|--------------------------------------------------------------------------
*/
if (!function_exists('arrayClear')) {
    /**
     * Remove null or optional empty entries from array
     *
     * @param array $array
     * @param bool  $removeEmptyValues
     * @return array
     * @deprecated Use`arrayClean` or `NormanHuth\Helpers\Arr::clean`
     */
    function arrayClear(array $array, bool $removeEmptyValues = false): array
    {
        return arrayClean($array, $removeEmptyValues);
    }

    /**
     * Remove null or optional empty entries from array
     *
     * @param array $array
     * @param bool  $removeEmptyValues
     * @return array
     */
    function arrayClean(array $array, bool $removeEmptyValues = false): array
    {
        return Arr::clean($array, $removeEmptyValues);
    }
}

if (!function_exists('arrayKeyMap')) {
    /**
     * Array map on array keys
     *
     * @param callable $callback
     * @param array    $array
     * @return array
     */
    function arrayKeyMap(callable $callback, array $array): array
    {
        return Arr::keyMap($callback, $array);
    }
}

if (!function_exists('arrayReplaceNullValueWithEmptyString')) {
    /**
     * Replace every null value with empty string in an array
     *
     * @param $value
     * @return void
     * @deprecated
     */
    function arrayReplaceNullValueWithEmptyString(&$value): void
    {
        Arr::replaceNullValueWithEmptyString($value);
    }
}

/*
|--------------------------------------------------------------------------
| String & Int
|--------------------------------------------------------------------------
*/

if (!function_exists('strSpaceBeforeCapitals')) {
    /**
     * Add whitespace before every upper char
     *
     * @param string $string
     * @return string
     * @deprecated
     */
    function strSpaceBeforeCapitals(string $string): string
    {
        return Str::spaceBeforeCapitals($string);
    }
}

if (function_exists('strRemoveNonASCIICharacters')) {
    /**
     * Remove non ASCII characters from a string
     *
     * @param string $string
     * @return string
     * @deprecated
     */
    function strRemoveNonASCIICharacters(string $string): string
    {
        return Str::removeNonASCIICharacters($string);
    }
}

if (!function_exists('strExcerpt')) {
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
    function strExcerpt(string $text, int $limit = 100, ?string $excerpt = null, string $end = '...'): string
    {
        return Str::getExcerpt($text, $limit, $excerpt, $end);
    }
}

if (!function_exists('strSlug')) {
    /**
     * Generate a URL friendly "slug" from a given string.
     *
     * @param string      $title
     * @param string      $separator
     * @param string|null $language
     * @param string[]    $dictionary
     * @return string
     */
    function strSlug(string $title, string $separator = '-', ?string $language = null, array $dictionary = ['@' => 'at']): string
    {
        return Str::slug($title, $separator, $language, $dictionary);
    }
}

if (!function_exists('ceilUpNearest')) {
    /**
     * Round up to the nearest multiple of `E`
     *
     * @param int|float $num
     * @param int       $step
     * @return float
     */
    function ceilUpNearest(int|float $num, int $step = 5): float
    {
        return Str::ceilUpNearest($num, $step);
    }
}

if (!function_exists('fillDigits')) {
    /**
     * Format int with leading zeros
     *
     * @param int|null $int $int = 5
     * @param int      $digits
     * @return string|null
     */
    function fillDigits(?int $int, int $digits = 5): ?string
    {
        return Str::fillDigits($int, $digits);
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
     * @deprecated Use`parseMarkdown` or `Str::markdown`
     */
    function paresMarkdown(string $string): string
    {
        return parseMarkdown($string);
    }
}

if (!function_exists('parseMarkdown')) {
    /**
     * Converts GitHub flavored Markdown into HTML.
     *
     * @param string $string
     * @param array  $options
     * @return string
     */
    function parseMarkdown(string $string, array $options = []): string
    {
        return Str::markdown($string, $options);
    }
}

if (!function_exists('jsonPrettyEncode')) {
    /**
     * Returns the JSON representation pretty and unescaped of a value
     *
     * @param mixed $value
     * @return bool|string
     */
    function jsonPrettyEncode(mixed $value): bool|string
    {
        return Str::jsonPrettyEncode($value);
    }
}

if (!function_exists('normalizeUserSubmit')) {
    /**
     * Trim every line and remove doubled whitespaces and new lines
     *
     * @param string $string
     * @return string
     */
    function normalizeUserSubmit(string $string): string
    {
        return Str::normalizeUserSubmit($string);
    }
}

if (!function_exists('emojiToUnicode')) {
    /**
     * Encode emojis to unicode
     *
     * @param $emoji
     * @return string
     * @deprecated Use \NormanHuth\Helpers\Str::emojiToUnicode
     */
    function emojiToUnicode($emoji): string
    {
        return Str::emojiToUnicode($emoji);
    }
}

if (!function_exists('isJson')) {
    /**
     * Determine if a given string is valid JSON
     *
     * @param string $value
     * @return bool
     */
    function isJson(string $value): bool
    {
        return Str::isJson($value);
    }
}

if (!function_exists('isAscii')) {
    /**
     * Determine if a given string is 7 bit ASCII
     *
     * @param string $value
     * @return bool
     * @deprecated Use Str::isAscii
     */
    function isAscii(string $value): bool
    {
        return Str::isAscii($value);
    }
}

if (!function_exists('isUuid')) {
    /**
     * Determine if a given string is a valid UUID
     *
     * @param string $value
     * @return bool
     * @deprecated Use Str::isUuid
     */
    function isUuid(string $value): bool
    {
        return Str::isUuid($value);
    }
}

/*
|--------------------------------------------------------------------------
| Tools
|--------------------------------------------------------------------------
*/

if (!function_exists('randomWord')) {
    /**
     * Return a random word by array of words
     *
     * @param array $words
     * @return string
     * @deprecated Use Arr::random()
     */
    function randomWord(array $words): string
    {
        return Str::randomWord($words);
    }
}

if (!function_exists('lastAnd')) {
    /**
     * Replace the last comma in a list with `and`
     *
     * @param string|array $content
     * @param string       $word
     * @param string       $glue
     * @param string|null  $translateFunction
     * @return string
     * @deprecated Use \NormanHuth\Helpers\Str::lastAnd
     */
    function lastAnd(string|array $content, string $word = 'and', string $glue = ',', ?string $translateFunction = null): string
    {
        return Str::lastAnd($content, $word, $glue, $translateFunction);
    }
}

if (!function_exists('generateSerialNo')) {
    /**
     * Generate a serial number
     * Example: YCY8N-DWCII-W63JY-A71PA-FTUMU
     *
     * @param bool   $toUpper
     * @param int    $parts
     * @param int    $partLength
     * @param string $separator
     * @return string
     * @deprecated Use \NormanHuth\Helpers\Str::generateSerialNo
     */
    function generateSerialNo(bool $toUpper = true, int $parts = 5, int $partLength = 5, string $separator = '-'): string
    {
        return Str::generateSerialNo($toUpper, $parts, $partLength, $separator);
    }
}

if (!function_exists('dataGetByJsonFile')) {
    /**
     * Get data key by JSON file
     *
     * @param string                $file
     * @param array|int|string|null $key
     * @param mixed                 $default
     * @return array|mixed
     * @deprecated Use \NormanHuth\Helpers\File::dataGetByJsonFile
     */
    function dataGetByJsonFile(string $file, array|int|string|null $key = null, mixed $default = null): mixed
    {
        return File::dataGetByJsonFile($file, $key, $default);
    }
}

if (!function_exists('httpBuildQueryUrl')) {
    /**
     * Domain with queries via `http_build_query`
     *
     * @param string $url
     * @param array  $params
     * @return string
     */
    function httpBuildQueryUrl(string $url, array $params = []): string
    {
        return Str::httpBuildQueryUrl($url, $params);
    }
}

if (!function_exists('toolGenerateSerialNo')) {
    /**
     * Generate a serial number
     * Example: YCY8N-DWCII-W63JY-A71PA-FTUMU
     *
     * @param bool   $toUpper
     * @param int    $parts
     * @param int    $partLength
     * @param string $separator
     * @return string
     * @deprecated Use \NormanHuth\Helpers\Str::generateSerialNo
     */
    function toolGenerateSerialNo(bool $toUpper = true, int $parts = 5, int $partLength = 5, string $separator = '-'): string
    {
        return Str::generateSerialNo($toUpper, $parts, $partLength, $separator);
    }
}

if (!function_exists('zipDirectory')) {
    /**
     * Create a file archive inclusive files in directories, compressed with Zip
     *
     * @param string $target
     * @param string $source
     * @param bool   $overwriteArchive
     * @return bool
     * @deprecated Use \NormanHuth\Helpers\File::zipDirectory
     */
    function zipDirectory(string $target, string $source, bool $overwriteArchive = false): bool
    {
        return File::zipDirectory($target, $source, $overwriteArchive);
    }
}

if (!function_exists('unzip')) {
    /**
     * Extract Zip archive contents
     *
     * @param string $source
     * @param string $target
     * @return bool
     */
    function unzip(string $source, string $target): bool
    {
        return File::unzip($source, $target);
    }
}

/*
|--------------------------------------------------------------------------
| Filesystem
|--------------------------------------------------------------------------
*/
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

/*
|--------------------------------------------------------------------------
| Image & Color
|--------------------------------------------------------------------------
*/
if (!function_exists('randomHexColor')) {
    /**
     * Get a random HEX color
     *
     * @return string
     * @deprecated Use \NormanHuth\Helpers\Str::randomHexColor
     */
    function randomHexColor(): string
    {
        return Str::randomHexColor();
    }
}

if (!function_exists('imageIsPortrait')) {
    /**
     * Check if an image is in portrait format
     *
     * @param string $file
     * @return bool
     * @deprecated Use \NormanHuth\Helpers\Image::isPortrait
     */
    function isPortrait(string $file): bool
    {
        return Image::isPortrait($file);
    }
}

/*
|--------------------------------------------------------------------------
| Urls
|--------------------------------------------------------------------------
*/
if (!function_exists('urlGetDomain')) {
    /**
     * Get Domain name from URL
     *
     * @param string $url
     * @return string
     * @deprecated Use \NormanHuth\Helpers\Str::getDomain
     */
    function urlGetDomain(string $url): string
    {
        return Str::getDomain($url);
    }
}

if (!function_exists('randomHexColorPart')) {
    /**
     * Get a part of a HEX color
     *
     * @return string
     * @deprecated Use \NormanHuth\Helpers\Str::randomHexColorPart
     */
    function randomHexColorPart(): string
    {
        return Str::randomHexColorPart();
    }
}
