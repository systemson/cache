<?php
/**
 * This file is part of the Amber/Cache package.
 *
 * @package Amber/Cache
 * @author Deivi Peña <systemson@gmail.com>
 * @license GPL-3.0-or-later
 * @license https://opensource.org/licenses/gpl-license GNU Public License
 */

namespace Amber\Cache\Driver;

use Amber\Cache\Config\ConfigAwareInterface;
use Amber\Cache\Config\ConfigAwareTrait;
use Amber\Validator\Validator;
use Psr\SimpleCache\CacheInterface;

/**
 * Base class for all cache drivers.
 */
abstract class CacheDriver implements CacheInterface, ConfigAwareInterface
{
    use Validator, ConfigAwareTrait;

    /**
     * Instantiates the Cache Driver.
     *
     * @param string $config The config environment variables.
     */
    public function __construct($config = [])
    {
        $this->setConfig($config);
    }

    /**
     * Gets multiple cached items.
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
     * Stores a set of key => value pairs in the file system.
     *
     * @param array    $items A list of key => value pairs of items to store.
     * @param null|int $ttl   Optional. The TTL value of this item.
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
