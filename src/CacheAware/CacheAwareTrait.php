<?php
/**
 * This file is part of the Amber/Cache package.
 *
 * @package Amber/Cache
 * @author Deivi Peña <systemson@gmail.com>
 * @license GPL-3.0-or-later
 * @license https://opensource.org/licenses/gpl-license GNU Public License
 */

namespace Amber\Cache\CacheAware;

use Psr\SimpleCache\CacheInterface;

/**
 * CacheAware implementation.
 */
trait CacheAwareTrait
{
    /**
     * @var The instance of the cache driver.
     */
    protected $cache_driver;

    /**
     * Sets the cache driver.
     *
     * @param CacheInterface $driver An instance of the cache driver.
     *
     * @return void
     */
    public function setCache(CacheInterface $driver): void
    {
        $this->cache_driver = $driver;
    }

    /**
     * Gets the cache driver.
     *
     * @return CacheInterface The instance of the cache driver.
     */
    public function getCache(): CacheInterface
    {
        return $this->cache_driver;
    }
}
