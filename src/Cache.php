<?php

namespace Amber\Cache;

class Cache
{
    /**
     * @var The instance of the cache driver
     */
    private static $instance;

    /**
     * Singleton implementation.
     */
    public static function getInstance()
    {
        /* Checks if the CacheDriver is already instantiated. */
        if (!self::$instance instanceof CacheDriver) {
            /* Instantiate the CacheDriver */
            self::$instance = $driver ?? new FileCache();
        }

        return self::$instance;
    }

    public static function driver(CacheDriver $driver)
    {
        return self::$instance = $driver;
    }

    public static function __callStatic($method, $args)
    {
        return call_user_func_array([self::getInstance(), $method], $args);
    }
}
