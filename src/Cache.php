<?php

namespace Amber\Cache;

use Amber\Cache\Driver\FileCache;
use Psr\SimpleCache\CacheInterface;

class Cache
{
    public $drivers = [
        'file' => Amber\Cache\Driver\FileCache::class,
        'json' => Amber\Cache\Driver\JsonCache::class,
        'array' => Amber\Cache\Driver\ArrayCache::class,
    ];
    /**
     * @var The instance of the cache driver
     */
    private static $instance;

    /**
     * Singleton implementation.
     */
    public static function getInstance()
    {
        /* Checks if the use CacheInterface is already instantiated. */
        if (!self::$instance instanceof CacheInterface) {

            self::$instance = new FileCache();
        }

        return self::$instance;
    }

    public static function driver(CacheInterface $driver)
    {
        return self::$instance = $driver;
    }

    public static function __callStatic($method, $args)
    {
        return call_user_func_array([self::getInstance(), $method], $args);
    }
}
