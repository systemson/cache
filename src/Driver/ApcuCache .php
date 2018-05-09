<?php

namespace Amber\Cache\Driver;

class ApcuCache extends CacheDriver
{
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

            if ($this->has($key)) {
                return apcu_fetch($key);
            }

            return $default;
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

            return apcu_store($key, $value, $ttl * 60);
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

            return apcu_delete($key);
        }

        return false;
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
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return bool
     */
    public function has($key)
    {
        if (is_string($key)) {
            return (boolean) apcu_exists($key);
        }

        return false;
    }
}
