<?php

namespace Amber\Cache\Driver;

use Amber\Cache\Driver\Base\FileCache;

class JsonCache extends FileCache
{
    /**
     * Get an item from the cache.
     *
     * @param string $key     The cache key.
     * @param mixed  $default Return value if the key does not exist.
     *
     * @throws \InvalidArgumentException
     *
     * @return mixed The cache value, or $default.
     */
    public function get($key, $default = null)
    {
        return $this->getRaw($key) ?? json_encode($default);
    }

    /**
     * Store the cache item in the file system.
     *
     * @param string    $key   The key of the cache item.
     * @param mixed     $value The value of the item to store.
     * @param null|int| $ttl   Optional. The TTL value of this item.
     *
     * @throws \InvalidArgumentException
     *
     * @return bool True on success and false on failure.
     */
    public function set($key, $value, $ttl = null)
    {
        return $this->setRaw('json_encode', $key, $value, $ttl);
    }
}
