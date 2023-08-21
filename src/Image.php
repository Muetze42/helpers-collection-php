<?php

namespace NormanHuth\Helpers;

class Image
{
    /**
     * Check if an image is in portrait format.
     *
     * @param string $file
     * @return bool
     */
    public static function isPortrait(string $file): bool
    {
        list($width, $height) = getimagesize($file);

        return $height > $width;
    }
}
