<?php

namespace Amber\Cache\Driver;

use Amber\Filesystem\Filesystem;
use Carbon\Carbon;

class JsonCache extends CacheDriver
{
    /*
     * @var $path The base path to the cache folder.
     */
    public $folder = '/tmp/cache';

    /*
     * @var $filesystem The file system instance.
     */
    public $filesystem;

    /**
     * @param string $path The base path to the cache folder.
     */
    public function __construct($path = null)
    {
        $this->filesystem = Filesystem::getInstance($path ?? getcwd());
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
        if (is_string($key)) {
            $item = $this->getCachedItem($key);

            if ($item && !$this->isExpired($item)) {
                return $item->value;
            }
        }

        return $default != null ? json_encode($default) : null;
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

        $content = $expiration."\r\n".json_encode($value);

        $this->filesystem->put($this->folder.'/'.sha1($key), $content);

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
        $this->filesystem->delete($this->folder.'/'.sha1($key));

        return true;
    }

    /**
     * Deletes the cache folder.
     *
     * @return bool True on success and false on failure.
     */
    public function clear()
    {
        $this->filesystem->deleteDir($this->folder);

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

    public function getCachedItem($key)
    {
        if ($this->filesystem->has($this->folder.'/'.sha1($key))) {
            $item = explode("\r\n", $this->filesystem->read($this->folder.'/'.sha1($key)));

            return (object) [
                'key'    => $key,
                'expire' => $item[0] ?? null,
                'value'  => $item[1] ?? null,
            ];
        }
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
