<?php

namespace Amber\Cache\CacheAware;

use Amber\Cache\Driver\CacheDriver;

trait CacheAwareTrait
{
    /**
     * @var The instance of the cache driver.
     */
    protected $cacheDriver;

    /**
     * Sets the cache driver.
     *
     * @param CacheDriver $driver An instance of the cache driver.
     *
     * @return void
     */
    public function setCache(CacheDriver $driver)
    {
        $this->cacheDriver = $driver;
    }

    /**
     * Gets the cache driver.
     *
     * @param CacheDriver $driver An instance of the cache driver.
     *
     * @return CacheDriver The instance of the cache driver.
     */
    public function getCache(): CacheDriver
    {
        return $this->cacheDriver;
    }
}
