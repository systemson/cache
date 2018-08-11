<?php

namespace Amber\Cache\Driver;

use Amber\Cache\Exception\InvalidArgumentException;

class ApcuCache extends CacheDriver
{
    /**
     * Checks if APCu is enabled otherwise throws an Exception.
     */
    public function __construct()
    {
        if (!extension_loaded('apcu') || !ini_get('apc.enabled')) {
            throw new \Exception('The PHP extension APCu is not enabled');
        }
    }

    /**
     * Get an item from the cache.
     *
     * @param string $key     The cache key.
     * @param mixed  $default Return value if the key does not exist.
     *
     * @throws InvalidArgumentException
     *
     * @return mixed The cache value, or $default.
     */
    public function get($key, $default = null)
    {
        /* If $key is not valid string throws InvalidArgumentException */
        if (!$this->isString($key)) {
            throw new InvalidArgumentException('Cache key must be not empty string');
        }

        if ($this->has($key)) {
            return apcu_fetch($key);
        }

        return $default;
    }

    /**
     * Store the item in the array.
     *
     * @param string    $key   The key of the cache item.
     * @param mixed     $value The value of the item to store.
     * @param null|int| $ttl   Optional. The TTL value of this item.
     *
     * @throws InvalidArgumentException
     *
     * @return bool True on success and false on failure.
     */
    public function set($key, $value, $ttl = null)
    {
        /* If $key is not valid string throws InvalidArgumentException */
        if (!$this->isString($key)) {
            throw new InvalidArgumentException('Cache key must be not empty string');
        }

        return apcu_store($key, $value, $ttl * 60);
    }

    /**
     * Delete an item from the cache by its unique key.
     *
     * @param string $key The unique cache key of the item to delete.
     *
     * @throws InvalidArgumentException
     *
     * @return bool True on success, false on error.
     */
    public function delete($key)
    {
        /* If $key is not valid string throws InvalidArgumentException */
        if (!$this->isString($key)) {
            throw new InvalidArgumentException('Cache key must be not empty string');
        }

        return apcu_delete($key);
    }

    /**
     * Deletes the cache folder.
     *
     * @return bool True on success and false on failure.
     */
    public function clear()
    {
        return apcu_clear_cache();
    }

    /**
     * Determines whether an item is present in the cache.
     *
     * @param string $key The cache item key.
     *
     * @throws InvalidArgumentException
     *
     * @return bool
     */
    public function has($key)
    {
        /* If $key is not valid string throws InvalidArgumentException */
        if (!$this->isString($key)) {
            throw new InvalidArgumentException('Cache key must be not empty string');
        }

        return (bool) apcu_exists($key);
    }
}
