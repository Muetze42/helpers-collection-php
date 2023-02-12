<?php

namespace NormanHuth\Helpers;

use ZipArchive;

class Tool
{
    /**
     * Create a file archive inclusive files in directories, compressed with Zip
     *
     * @param string $target
     * @param string $source
     * @param bool $overwriteArchive
     * @param int|null $flags
     * @return bool
     */
    public static function zipDirectory(string $target, string $source, bool $overwriteArchive = false, ?int $flags = null): bool
    {
        $zip = new ZipArchive;

        if (!$flags) {
            $flags = $overwriteArchive ? ZipArchive::CREATE | ZipArchive::OVERWRITE : ZipArchive::CREATE;
        }

        if ($zip->open($target, $flags) === true) {
            $files = \Illuminate\Support\Facades\File::allFiles(
                $source
            );

            foreach ($files as $file) {
                $zip->addFile($file->getPathname(), $file->getRelativePathname());
            }

            return $zip->close();
        }

        return false;
    }

    /**
     * Extract Zip archive contents
     *
     * @param string $source
     * @param string $target
     * @return bool
     */
    public static function unzip(string $source, string $target): bool
    {
        $zip = new ZipArchive;
        if ($zip->open($source) === true) {
            $zip->extractTo($target);

            return $zip->close();
        }

        return false;
    }
}
