<?php

namespace NormanHuth\Helpers\Traits;

use Composer\Autoload\ClassLoader;
use NormanHuth\Helpers\Exception\FileNotFoundException;
use ReflectionClass;

trait PathTrait
{
    /**
     * @var string|null
     */
    protected static ?string $path = null;

    /**
     * Set different composer package path
     *
     * @param string $path
     * @throws FileNotFoundException
     * @return void
     */
    public static function setProjectPath(string $path): void
    {
        $path = rtrim($path, '\\/');

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
            $path = dirname(__DIR__, 5);
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
