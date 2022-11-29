<?php

namespace NormanHuth\Helpers;

class Url
{
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
