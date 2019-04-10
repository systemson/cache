<?php
/**
 * This file is part of the Amber/Cache package.
 *
 * @package Amber/Cache
 * @author Deivi Peña <systemson@gmail.com>
 * @license GPL-3.0-or-later
 * @license https://opensource.org/licenses/gpl-license GNU Public License
 */

namespace Amber\Cache\Driver\Base;

use Amber\Cache\Driver\CacheDriver;
use Amber\Cache\Exception\InvalidArgumentException;
use League\Flysystem\Filesystem;
use Carbon\Carbon;
use Psr\Cache\CacheItemInterface;
use League\Flysystem\Adapter\Local;

/**
 * Common abstract class for file based cache drivers.
 */
abstract class FileCache extends CacheDriver
{
    protected $filesystem;

    public function __construct($path)
    {
        $this->filesystem($path);
    }

    /**
     * Gets a Filesystem instance.
     *
     * @return instance Filesystem
     */
    public function filesystem(string $path = null)
    {
        if (!$this->filesystem instanceof Filesystem) {
            $local = new Local($path);

            $this->filesystem = new Filesystem($local);
        }

        return $this->filesystem;
    }

    /**
     * Get an item from the cache.
     *
     * @param string $key      The cache key.
     * @param mixed  $function Return value if the key does not exist.
     *
     * @throws Amber\Cache\Exception\InvalidArgumentException
     *
     * @return mixed|void The cache value, or void.
     */
    protected function getRaw($key, $function = null)
    {
        if (!$this->isString($key)) {
            /* If $key is not valid string throws InvalidArgumentException */
            throw new InvalidArgumentException('Cache key must be not empty string');
        }

        $item = $this->getCachedItem($key);

        if ($item && !$this->isExpired($item)) {
            return !is_null($function) ? $function($item->get()) : $item->get();
        }
    }

    /**
     * Store the cache item in the file system.
     *
     * @param callable  $function The callable to apply to the item's value.
     * @param string    $key      The key of the cache item.
     * @param mixed     $value    The value of the item to store.
     * @param null|int| $ttl      Optional. The TTL value of this item.
     *
     * @throws Amber\Cache\Exception\InvalidArgumentException
     *
     * @return bool True on success and false on failure.
     */
    protected function setRaw($function, $key, $value, $ttl = null)
    {
        /* If $key is not valid string throws InvalidArgumentException */
        if (!$this->isString($key)) {
            throw new InvalidArgumentException('Cache key must be not empty string');
        }

        $expiration = $ttl ? Carbon::now()->addMinutes($ttl) : null;

        $content = $expiration . PHP_EOL . $function($value);

        $this->filesystem()->put(sha1($key), $content);
        return true;
    }

    /**
     * Delete an item from the cache by its unique key.
     *
     * @param string $key The unique cache key of the item to delete.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return bool True on success, false on fail.
     */
    public function delete($key)
    {
        /* If $key is not valid string throws InvalidArgumentException */
        if (!$this->isString($key)) {
            throw new InvalidArgumentException('Cache key must be not empty string');
        }

        $path = sha1($key);

        if ($this->filesystem()->has($path)) {
            $this->filesystem()->delete($path);
            return true;
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
        foreach ($this->filesystem()->listContents() as $file) {
            $this->filesystem()->delete($file['path']);
        }

        return true;
    }

    /**
     * Whether an item is present in the cache.
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

        if ($this->getRaw($key)) {
            return true;
        }

        return false;
    }

    /**
     * Returns a CacheItemClass for the.
     *
     * @param string $key The cache item key.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return CacheItemInterface
     */
    public function getCachedItem($key)
    {
        $path = sha1($key);

        if ($this->filesystem()->has($path)) {
            $item = explode(PHP_EOL, $this->filesystem()->read($path), 2);

            return new CacheItemClass($key, $item[1] ?? null, $item[0] ?? null);
        }
    }

    /**
     * Whether an item from the cache is expired. If it does, deletes it from the file system.
     *
     * @param CacheItemInterface $item The item to evaluate.
     *
     * @return
     */
    public function isExpired(CacheItemInterface $item)
    {
        if ($item->isExpired()) {
            $this->delete($item->getKey());

            return true;
        }

        return false;
    }
}
