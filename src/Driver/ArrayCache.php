<?php

namespace Amber\Cache\Driver;

class ArrayCache extends CacheDriver
{
    /*
     * @var $cache The array containing the cached items.
     */
    public $cache;

    /**
     * Get an item from the cache.
     *
     * @param string $key     The cache key.
     * @param mixed  $default Return value if the key does not exist.
     *
     * @throws Amber\Cache\InvalidArgumentException
     *
     * @return mixed The cache value, or $default.
     */
    public function get($key, $default = null)
    {
        if (is_string($key)) {
            return $this->cache[$key] ?? $default;
        }

        return false;
    }

    /**
     * Store the item in the array.
     *
     * @param string    $key   The key of the cache item.
     * @param mixed     $value The value of the item to store.
     * @param null|int| $ttl   Optional. The TTL value of this item.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return bool True on success and false on failure.
     */
    public function set($key, $value, $ttl = null)
    {
        if (is_string($key)) {
            $this->cache[$key] = $value;

            return true;
        }

        return false;
    }

    /**
     * Delete an item from the cache by its unique key.
     *
     * @param string $key The unique cache key of the item to delete.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return bool True on success, false on error.
     */
    public function delete($key)
    {
        if (is_string($key)) {
            unset($this->cache[$key]);
        }

        return true;
    }

    /**
     * Deletes the cache folder.
     *
     * @return bool True on success and false on failure.
     */
    public function clear()
    {
        $this->cache = [];

        return true;
    }

    /**
     * Determines whether an item is present in the cache.
     *
     * @param string $key The cache item key.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return bool
     */
    public function has($key)
    {
        if (is_string($key)) {
            return isset($this->cache[$key]);
        }

        return false;
    }
}
