<?php

namespace Amber\Cache\Driver;

use Amber\Common\Validator;
use Psr\SimpleCache\CacheInterface;

abstract class CacheDriver implements CacheInterface
{
    use Validator;

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
}
