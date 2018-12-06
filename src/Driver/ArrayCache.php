<?php

namespace Amber\Cache\Driver;

use Amber\Cache\Exception\InvalidArgumentException;
use Amber\Collection\CollectionAware\CollectionAwareInterface;
use Amber\Collection\CollectionAware\CollectionAwareTrait;

class ArrayCache extends CacheDriver implements CollectionAwareInterface
{
    use CollectionAwareTrait;

    /**
     * Instantiates the Cache Driver.
     *
     * @param string $config The config environment variables.
     */
    public function __construct($config = [])
    {
        $this->setConfig($config);
        $this->initCollection($config);
    }

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
        /* If $key is not valid string throws InvalidArgumentException */
        if (!$this->isString($key)) {
            throw new InvalidArgumentException('Cache key must be not empty string');
        }

        return $this->getCollection()->get($key) ?? $default;
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
        /* If $key is not valid string throws InvalidArgumentException */
        if (!$this->isString($key)) {
            throw new InvalidArgumentException('Cache key must be not empty string');
        }

        return $this->getCollection()->set($key, $value);
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
        /* If $key is not valid string throws InvalidArgumentException */
        if (!$this->isString($key)) {
            throw new InvalidArgumentException('Cache key must be not empty string');
        }

        return $this->getCollection()->delete($key);
    }

    /**
     * Deletes the cache folder.
     *
     * @return bool True on success and false on failure.
     */
    public function clear()
    {
        $this->getCollection()->clear();

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
        /* If $key is not valid string throws InvalidArgumentException */
        if (!$this->isString($key)) {
            throw new InvalidArgumentException('Cache key must be not empty string');
        }

        return $this->getCollection()->has($key);
    }
}
