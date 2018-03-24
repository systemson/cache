<?php

namespace Amber\Cache;

use Amber\Cache\CacheDriver;
use Amber\Cache\FileCache;

class Cache
{
    private static $instance;

    /**
     * Singleton implementation.
     */
    private static function driver(CacheDriver $driver = null)
    {
        /** Checks if the CacheDriver is already instantiated. */
        if (!self::$instance instanceof CacheDriver)
        {
            /** Instantiate the CacheDriver */
            self::$instance = $driver ?? new FileCache();
        }

        return self::$instance;
    }

    public static function __callStatic($method, $args)
    {
        return call_user_func_array([self::$instance ?? self::driver(), $method], $args);
    }
}
