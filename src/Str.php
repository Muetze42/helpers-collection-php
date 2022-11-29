<?php

namespace NormanHuth\Helpers;

use Illuminate\Support\Str as BaseStr;

class Str extends BaseStr
{
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
     * @param string $title
     * @param string $separator
     * @param string|null $language
     * @param array<string, string> $dictionary
     * @return string
     */
    public static function slug($title, $separator = '-', $language = 'en', $dictionary = ['@' => 'at']): string
    {
        if (!$language && class_exists('Illuminate\Support\Facades\App')) {
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
     * @param array $params
     * @return string
     */
    public static function httpBuildQueryUrl(string $url, array $params = []): string
    {
        $arg_separator = parse_url($url, PHP_URL_QUERY) ? '&' : '?';

        return $url.$arg_separator.http_build_query($params);
    }
}
