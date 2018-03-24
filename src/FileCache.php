<?php

namespace Amber\Cache;

use Amber\Filesystem\Filesystem;
use Carbon\Carbon;

class FileCache extends CacheDriver
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

            $item = $this->getCachedItem($key);

            if(!$this->isExpired($item)) {
                return unserialize($item->value);
            }
        }

        return $default;
    }

    /**
     * Store the cache item in the file system.
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
        $expiration = $ttl ? Carbon::now()->addMinutes($ttl) : null;

        $content = $expiration."\r\n".serialize($value);

        Filesystem::put('tmp/cache/'.sha1($key), $content);

        return true;
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
        Filesystem::delete('tmp/cache/'.sha1($key));

        return true;
    }

    /**
     * Wipes clean the entire cache's keys.
     *
     * @return bool True on success and false on failure.
     */
    public function clear()
    {
        Filesystem::deleteDir('tmp/cache');

        return true;
    }

    /**
     * Obtains multiple cache items by their unique keys.
     *
     * @param iterable $keys    A list of keys that can obtained in a single operation.
     * @param mixed    $default Default value to return for keys that do not exist.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *                                                   MUST be thrown if $keys is neither an array nor a Traversable,
     *                                                   or if any of the $keys are not a legal value.
     *
     * @return iterable A list of key => value pairs. Cache keys that do not exist or are stale will have $default as value.
     */
    public function getMultiple($keys, $default = null)
    {
    }

    /**
     * Persists a set of key => value pairs in the cache, with an optional TTL.
     *
     * @param iterable               $values A list of key => value pairs for a multiple-set operation.
     * @param null|int|\DateInterval $ttl    Optional. The TTL value of this item. If no value is sent and
     *                                       the driver supports TTL then the library may set a default value
     *                                       for it or let the driver take care of that.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *                                                   MUST be thrown if $values is neither an array nor a Traversable,
     *                                                   or if any of the $values are not a legal value.
     *
     * @return bool True on success and false on failure.
     */
    public function setMultiple($values, $ttl = null)
    {
    }

    /**
     * Deletes multiple cache items in a single operation.
     *
     * @param iterable $keys A list of string-based keys to be deleted.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *                                                   MUST be thrown if $keys is neither an array nor a Traversable,
     *                                                   or if any of the $keys are not a legal value.
     *
     * @return bool True if the items were successfully removed. False if there was an error.
     */
    public function deleteMultiple($keys)
    {
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
        if(is_string($key)) {
            if($this->get($key)) {
                return true;
            }

            return false;
        }
    }

    public function getCachedItem($key)
    {
        if (Filesystem::has('tmp/cache/'.sha1($key))) {
            $item = explode("\r\n", Filesystem::read('tmp/cache/'.sha1($key)));

        }
        return (object) [
            'key' => $key,
            'expire' => $item[0] ?? null,
            'value' => $item[1] ?? null,
        ];
    }

    public function isExpired($item)
    {
        if ($item->expire && $item->expire <= Carbon::now()) {
            $this->delete($item->key);
            return true;
        }

        return false;
    }
}
