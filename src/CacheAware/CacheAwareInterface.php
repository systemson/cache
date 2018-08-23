<?php

namespace Amber\Cache\CacheAware;

use Amber\Cache\Driver\CacheDriver;

interface CacheAwareInterface
{
    const VERSION = 'v-0.1.2-beta';

    /**
     * Sets the cache driver.
     *
     * @param CacheDriver $driver An instance of the cache driver.
     *
     * @return void
     */
    public function setCache(CacheDriver $driver);

    /**
     * Gets the cache driver.
     *
     * @param CacheDriver $driver An instance of the cache driver.
     *
     * @return CacheDriver The stored cache driver.
     */
    public function getCache(): CacheDriver;
}
