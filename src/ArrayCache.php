<?php

namespace Amber\Cache;

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
     * Get multiple cache items.
     *
     * @param array $keys    A list of cache keys.
     * @param mixed $default Default value for keys that do not exist.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return array A list of key => value pairs.
     */
    public function getMultiple($keys, $default = null)
    {
        foreach ($keys as $key) {
            $cache[$key] = $this->get($key) ?? $default;
        }

        return $cache;
    }

    /**
     * Store a set of key => value pairs in the file system.
     *
     * @param array    $values A list of key => value pairs of items to store.
     * @param null|int $ttl    Optional. The TTL value of this item.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return bool true
     */
    public function setMultiple($items, $ttl = null)
    {
        foreach ($items as $key => $value) {
            $this->set($key, $value, $ttl);
        }

        return true;
    }

    /**
     * Deletes multiple cache items.
     *
     * @param array $keys A list of cache keys.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return bool true
     */
    public function deleteMultiple($keys)
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }

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
            if ($this->get($key)) {
                return true;
            }
        }

        return false;
    }
}
