<?php

namespace NormanHuth\Helpers;

use Exception;
use NormanHuth\Helpers\Exception\FileNotFoundException;
use NormanHuth\Helpers\Traits\PathTrait;

class Package
{
    use PathTrait;

    /**
     * @var string
     */
    protected static string $string = '';

    /**
     * Get package.json path
     *
     * @throws Exception\FileNotFoundException
     * @return string
     */
    public static function getPackageJsonPath(): string
    {
        return static::getProjectPath().DIRECTORY_SEPARATOR.'package.json';
    }

    /**
     * Get package-lock.json path
     *
     * @throws Exception\FileNotFoundException
     * @return string
     */
    public static function getPackageLockJsonPath(): string
    {
        $file = static::getProjectPath().DIRECTORY_SEPARATOR.'package-lock.json';

        if (!file_exists($file)) {
            return throw new FileNotFoundException($file);
        }

        return $file;
    }

    /**
     * Get package.json content as array
     *
     * @throws FileNotFoundException
     * @return array
     */
    public static function getPackageJsonData(): array
    {
        $file = static::getPackageJsonPath();

        return json_decode(file_get_contents($file), true);
    }

    /**
     * Get package-lock.json content as array
     *
     * @throws FileNotFoundException
     * @return array
     */
    public static function getPackageLockJsonData(): array
    {
        $file = static::getPackageLockJsonPath();

        return json_decode(file_get_contents($file), true);
    }

    /**
     * Get package.json value
     *
     * @param array|int|string|null $key
     * @param mixed|null            $default
     * @throws FileNotFoundException
     * @return mixed
     */
    public static function getPackageJsonValue(array|int|string|null $key, mixed $default = null): mixed
    {
        return data_get(static::getPackageJsonData(), $key, $default);
    }

    /**
     * Get package-lock.json value
     *
     * @param array|int|string|null $key
     * @param mixed|null            $default
     * @throws FileNotFoundException
     * @return mixed
     */
    public static function getPackageLockJsonValue(array|int|string|null $key, mixed $default = null): mixed
    {
        return data_get(static::getPackageLockJsonData(), $key, $default);
    }

    /**
     * Get scripts
     *
     * @throws FileNotFoundException
     * @return array|null
     */
    public static function getScripts(): ?array
    {
        return static::getPackageJsonValue('scripts');
    }

    /**
     * Get dependencies
     *
     * @throws FileNotFoundException
     * @return array|null
     */
    public static function getDependencies(): ?array
    {
        return static::getPackageJsonValue('dependencies');
    }

    /**
     * Get development dependencies
     *
     * @throws FileNotFoundException
     * @return array|null
     */
    public static function getDevDependencies(): ?array
    {
        return static::getPackageJsonValue('devDependencies');
    }

    /**
     * Get package name
     *
     * @throws FileNotFoundException
     * @return string|null
     */
    public static function getName(): ?string
    {
        return static::getPackageJsonValue('name');
    }

    /**
     * Get package description
     *
     * @throws FileNotFoundException
     * @return string|null
     */
    public static function getDescription(): ?string
    {
        return static::getPackageJsonValue('description');
    }

    /**
     * Get package homepage
     *
     * @throws FileNotFoundException
     * @return string|null
     */
    public static function getHomepage(): ?string
    {
        return static::getPackageJsonValue('homepage');
    }

    /**
     * Get package version
     *
     * @throws FileNotFoundException
     * @return string|int|null
     */
    public static function getVersion(): int|string|null
    {
        return static::getPackageJsonValue('version');
    }

    /**
     * Get package license
     *
     * @throws FileNotFoundException
     * @return string|null
     */
    public static function getLicense(): ?string
    {
        return static::getPackageJsonValue('license');
    }

    /**
     * Get package keywords
     *
     * @throws FileNotFoundException
     * @return array|null
     */
    public static function getKeywords(): ?array
    {
        return static::getPackageJsonValue('keywords');
    }

    /**
     * Get package bugs
     *
     * @throws FileNotFoundException
     * @return array|null
     */
    public static function getBugs(): ?array
    {
        return static::getPackageJsonValue('bugs');
    }

    /**
     * Get package author
     *
     * @throws FileNotFoundException
     * @return array|string|null
     */
    public static function getAuthor(): array|string|null
    {
        return static::getPackageJsonValue('author');
    }

    /**
     * Get package bin
     *
     * @throws FileNotFoundException
     * @return array|string|null
     */
    public static function getBin(): array|string|null
    {
        return static::getPackageJsonValue('bin');
    }

    /**
     * Add dependency to package.json
     *
     * @param string     $package
     * @param string|int $version
     * @throws FileNotFoundException
     * @return bool|int
     */
    public static function setDependency(string $package, string|int $version): bool|int
    {
        $string = !empty(self::$string) ? self::$string : 'dependencies';

        $data = static::getPackageJsonData();
        data_set($data, $string.'.'.$package, $version);
        $dependencies = data_get($data, $string);
        ksort($dependencies);
        data_set($data, $string, $dependencies);
        $file = static::getPackageJsonPath();
        self::$string = '';

        return file_put_contents($file, jsonPrettyEncode($data));
    }

    /**
     * Add development dependency to package.json
     *
     * @param string     $package
     * @param string|int $version
     * @throws FileNotFoundException
     * @return bool|int
     */
    public static function setDevDependency(string $package, string|int $version): bool|int
    {
        self::$string = 'devDependencies';

        return static::setDependency($package, $version);
    }

    /**
     * Remove dependency from package.json
     *
     * @param string $package
     * @throws FileNotFoundException
     * @return bool|int
     */
    public static function remove(string $package): bool|int
    {
        $string = !empty(self::$string) ? self::$string : 'dependencies';

        $data = static::getPackageJsonData();

        try {
            unset($data[$string][$package]);
        } catch (Exception $exception) {
            return false;
        }

        $file = static::getPackageJsonPath();
        self::$string = '';

        return file_put_contents($file, jsonPrettyEncode($data));
    }

    /**
     * Remove development dependency from package.json
     *
     * @param string $package
     * @throws FileNotFoundException
     * @return bool|int
     */
    public static function removeDev(string $package): bool|int
    {
        self::$string = 'devDependencies';

        return static::remove($package);
    }

    /**
     * Add or update script to package.json
     *
     * @param string $command
     * @param string $execute
     * @throws FileNotFoundException
     * @return bool|int
     */
    public static function setScript(string $command, string $execute): bool|int
    {
        $data = static::getPackageJsonData();
        data_set($data, 'scripts.'.$command, $execute);
        $file = static::getPackageJsonPath();

        return file_put_contents($file, jsonPrettyEncode($data));
    }

    /**
     * Remove script from package.json
     *
     * @param string $command
     * @throws FileNotFoundException
     * @return bool|int
     */
    public static function removeScript(string $command): bool|int
    {
        $data = static::getPackageJsonData();
        try {
            unset($data['scripts'][$command]);
        } catch (Exception $exception) {
            return false;
        }
        $file = static::getPackageJsonPath();

        return file_put_contents($file, jsonPrettyEncode($data));
    }
}
