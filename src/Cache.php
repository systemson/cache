<?php
/**
 * This file is part of the Amber/Cache package.
 *
 * @package Amber/Cache
 * @author Deivi Peña <systemson@gmail.com>
 * @license GPL-3.0-or-later
 * @license https://opensource.org/licenses/gpl-license GNU Public License
 */

namespace Amber\Cache;

use Amber\Cache\Exception\InvalidArgumentException;
use Psr\SimpleCache\CacheInterface;

use Amber\Utils\Implementations\AbstractWrapper;

/**
 * Cache driver wrapper.
 *
 * @todo MUST implement other cache drivers.
 */
class Cache extends AbstractWrapper
{
    /**
     * @var Psr\SimpleCache\CacheInterface The instance of the cache driver
     */
    protected static $instance;

    /**
     * @var string The class accessor.
     */
    protected static $accessor = \Amber\Cache\Driver\SimpleCache::class;

    /**
     * @var array The method(s) that should be publicly exposed.
     */
    protected static $passthru = [
        'set',
        'has',
        'get',
        'delete',
        'clear',
        'setMultiple',
        'getMultiple',
        'deleteMultiple',
    ];

    /**
     * @var array List of cache drivers.
     */
    protected static $drivers = [
        'file'  => \Amber\Cache\Driver\SimpleCache::class,
        'json'  => \Amber\Cache\Driver\JsonCache::class,
        'array' => \Amber\Cache\Driver\ArrayCache::class,
        'apcu'  => \Amber\Cache\Driver\ApcuCache::class,
    ];

    /**
     * Returns an instance of the desired Cache driver.
     *
     * @param string $driver The driver to instantiate.
     *
     * @return CacheInterface An instance of the Cache driver.
     */
    public static function driver($driver)
    {
        if (isset(self::$drivers[$driver])) {
            $driver = self::$drivers[$driver];
        }

        if (class_exists($driver)) {
            self::setAccessor($driver);

            return self::$instance = self::getInstance();
        }

        throw new InvalidArgumentException("Cache driver \"{$driver}\" not found or could not be instantiated.");
    }
}
