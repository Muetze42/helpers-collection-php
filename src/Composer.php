<?php

namespace NormanHuth\Helpers;

use Composer\Autoload\ClassLoader;
use Illuminate\Support\Arr;
use NormanHuth\Helpers\Exception\FileNotFoundException;
use ReflectionClass;

class Composer
{
    /**
     * @var string
     */
    protected static string $string = '';

    /**
     * @var string|null
     */
    protected static ?string $path = null;

    /**
     * Get composer.json content as array
     *
     * @throws FileNotFoundException
     */
    public static function getComposerJsonData(): mixed
    {
        $file = self::getProjectPath().DIRECTORY_SEPARATOR.'composer.json';

        return json_decode(file_get_contents($file), true);
    }

    /**
     * Get composer.lock content as array
     *
     * @throws FileNotFoundException
     */
    public static function getComposerLockData(): mixed
    {
        $file = self::getProjectPath().DIRECTORY_SEPARATOR.'composer.lock';

        if (!file_exists($file)) {
            return throw new FileNotFoundException($file);
        }

        return json_decode(file_get_contents($file), true);
    }

    /**
     * Check if package is in requirements
     * Returns false or required version
     *
     * @param string $package
     * @throws FileNotFoundException
     * @return false|string|int
     */
    public static function isRequire(string $package): false|string|int
    {
        $data = static::getComposerJsonData();

        return data_get($data, 'require'.self::$string.'.'.$package, false);
    }

    /**
     * Check if package is in development requirements
     * Returns false or required version
     *
     * @param string $package
     * @throws FileNotFoundException
     * @return false|string|int
     */
    public static function isRequireDev(string $package): false|string|int
    {
        self::$string = '-dev';

        return static::isRequire($package);
    }

    /**
     * Get a composer.json value
     *
     * @param array|int|string|null $key
     * @param mixed|null            $default
     * @throws FileNotFoundException
     * @return array|mixed
     */
    public static function getComposerJsonValue(array|int|string|null $key, mixed $default = null): mixed
    {
        return data_get(static::getComposerJsonData(), $key, $default);
    }

    /**
     * Get the name of the package
     *
     * @throws FileNotFoundException
     * @return string|null
     */
    public static function getName(): ?string
    {
        return static::getComposerJsonValue('name');
    }

    /**
     * Get the description of the package
     *
     * @throws FileNotFoundException
     * @return string|null
     */
    public static function getDescription(): ?string
    {
        return static::getComposerJsonValue('description');
    }

    /**
     * Get the license of the package
     *
     * @throws FileNotFoundException
     * @return string|null
     */
    public static function getLicense(): ?string
    {
        return static::getComposerJsonValue('license');
    }

    /**
     * Get the homepage of the package
     *
     * @throws FileNotFoundException
     * @return string|null
     */
    public static function getHomepage(): ?string
    {
        return static::getComposerJsonValue('homepage');
    }

    /**
     * Get the requirements of the package
     *
     * @throws FileNotFoundException
     * @return array
     */
    public static function getRequirements(): array
    {
        return static::getComposerJsonValue('require', []);
    }

    /**
     * Get the development requirements of the package
     *
     * @throws FileNotFoundException
     * @return array
     */
    public static function getDevRequirements(): array
    {
        return static::getComposerJsonValue('require-dev', []);
    }

    /**
     * Get the minimum stability of the package
     *
     * @throws FileNotFoundException
     * @return string|null
     */
    public static function getStability(): ?string
    {
        return static::getComposerJsonValue('minimum-stability');
    }

    /**
     * Get autoload mappings
     *
     * @throws FileNotFoundException
     * @return array
     */
    public static function getAutoload(): array
    {
        return static::getComposerJsonValue('autoload'.static::$string, []);
    }

    /**
     * Get PSR-4 autoload mappings
     *
     * @throws FileNotFoundException
     * @return array
     */
    public static function getAutoloadPSR4(): array
    {
        return static::getComposerJsonValue('autoload.psr-4', []);
    }

    /**
     * Get autoloaded files
     *
     * @throws FileNotFoundException
     * @return array
     */
    public static function getAutoloadFiles(): array
    {
        return static::getComposerJsonValue('autoload.files', []);
    }

    /**
     * Get development autoload mappings
     *
     * @throws FileNotFoundException
     * @return array
     */
    public static function getDevAutoload(): array
    {
        return static::getComposerJsonValue('autoload-dev'.static::$string, []);
    }

    /**
     * Get PSR-4 development autoload mappings
     *
     * @throws FileNotFoundException
     * @return array
     */
    public static function getDevAutoloadPSR4(): array
    {
        return static::getComposerJsonValue('autoload-dev.psr-4', []);
    }

    /**
     * Get autoloaded development files
     *
     * @throws FileNotFoundException
     * @return array
     */
    public static function getDevAutoloadFiles(): array
    {
        return static::getComposerJsonValue('autoload-dev.files', []);
    }

    /**
     * Get the keywords of the package
     *
     * @throws FileNotFoundException
     * @return array
     */
    public static function getKeywords(): array
    {
        return static::getComposerJsonValue('keywords', []);
    }

    /**
     * Get the configuration of the package
     *
     * @throws FileNotFoundException
     * @return array
     */
    public static function getConfig(): array
    {
        return static::getComposerJsonValue('config', []);
    }

    /**
     * Get the extra values of the package
     *
     * @throws FileNotFoundException
     * @return array
     */
    public static function getExtras(): array
    {
        return static::getComposerJsonValue('extra', []);
    }

    /**
     * Get the scripts of the package
     *
     * @param string $event
     * @throws FileNotFoundException
     * @return array
     */
    public static function getScripts(string $event = ''): array
    {
        if ($event) {
            $event = '.'.$event;
        }

        return static::getComposerJsonValue('scripts'.$event, []);
    }

    /**
     * Get the repositories of the package
     *
     * @throws FileNotFoundException
     * @return array
     */
    public static function getRepositories(): array
    {
        return static::getComposerJsonValue('repositories', []);
    }

    /**
     * Get the authors of the package
     *
     * @throws FileNotFoundException
     * @return array
     */
    public static function getAuthors(): array
    {
        return static::getComposerJsonValue('authors', []);
    }

    /**
     * Get the vendor name of the package
     *
     * @throws FileNotFoundException
     * @return string|null
     */
    public static function getVendor(): ?string
    {
        $name = static::getName();
        if ($name) {
            return explode('/', $name)[0];
        }

        return null;
    }

    /**
     * Get the package name of the package
     *
     * @throws FileNotFoundException
     * @return string|null
     */
    public static function getPackage(): ?string
    {
        $name = static::getName();
        if ($name) {
            $parts = explode('/', $name);
            if (isset($parts[1])) {
                return $parts[1];
            }
        }

        return null;
    }

    /**
     * Return installed version composer package version via lock file.
     * Returns null if not found
     *
     * @param string $package
     * @param bool   $includeDev
     * @throws FileNotFoundException
     * @return string|int|null
     */
    public static function getLockedVersion(string $package, bool $includeDev = true): int|string|null
    {
        $data = static::getComposerLockData();
        $packages = data_get($data, 'packages');
        if ($includeDev) {
            $packages = array_merge($packages, data_get($data, 'packages-dev'));
        }
        $filtered = Arr::first($packages, function ($value) use ($package) {
            return !empty($value['name']) && $value['name'] == $package;
        });

        return data_get($filtered, 'version');
    }

    /**
     * Set different composer package path
     *
     * @param string $path
     * @throws FileNotFoundException
     * @return void
     */
    public static function setProjectPath(string $path): void
    {
        if (!file_exists($path.DIRECTORY_SEPARATOR.'composer.json')) {
            throw new FileNotFoundException($path.DIRECTORY_SEPARATOR.'composer.json');
        }

        self::$path = $path;
    }

    /**
     * Get Project root path
     *
     * @throws FileNotFoundException
     * @return string
     */
    public static function getProjectPath(): string
    {
        if (self::$path) {
            return self::$path;
        }

        if (!class_exists('\Composer\Autoload\ClassLoader')) {
            $path = dirname(__DIR__, 4);
        } else {
            $reflection = new ReflectionClass(ClassLoader::class);

            $path = dirname($reflection->getFileName(), 3);
        }

        $file = $path.DIRECTORY_SEPARATOR.'composer.json';
        if (!file_exists($file)) {
            return throw new FileNotFoundException($file);
        }

        $file = $path.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
        if (!file_exists($file)) {
            return throw new FileNotFoundException($file);
        }

        return $path;
    }
}
