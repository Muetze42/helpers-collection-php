<?php

namespace NormanHuth\Helpers;

use Illuminate\Support\Arr;

class Composer
{
    /**
     * Return installed version composer package version via lock file.
     * Returns null if not found
     *
     * @param string $package
     * @param bool   $includeDev
     * @return string|int|null
     */
    public static function getLockedVersion(string $package, bool $includeDev = true): int|string|null
    {
        $file = self::getProjectPath().DIRECTORY_SEPARATOR.'composer.lock';

        if (!file_exists($file)) {
            return null;
        }

        $lock = json_decode(file_get_contents($file), true);
        $packages = data_get($lock, 'packages');
        if ($includeDev) {
            $packages = array_merge($packages, data_get($lock, 'packages-dev'));
        }
        $filtered = Arr::first($packages, function ($value) use ($package) {
            return !empty($value['name']) && $value['name'] == $package;
        });

        return data_get($filtered, 'version');
    }

    /**
     * Get Project root path
     *
     * @return string
     */
    public static function getProjectPath(): string
    {
        if (!class_exists('\Composer\Autoload\ClassLoader')) {
            return dirname(__DIR__, 4);
        }

        $reflection = new \ReflectionClass(\Composer\Autoload\ClassLoader::class);

        return dirname($reflection->getFileName(), 3);
    }
}
