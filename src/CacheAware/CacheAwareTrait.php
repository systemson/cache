<?php

namespace Amber\Cache\CacheAware;

use Amber\Cache\Cache;
use Amber\Cache\Driver\CacheDriver;

trait CacheAwareTrait
{
    /**
     * @var The instance of the cache driver.
     */
    protected $cache_driver;

    /**
     * Sets the cache driver.
     *
     * @param CacheDriver $driver An instance of the cache driver.
     *
     * @return void
     */
    public function setCache(CacheDriver $driver): void
    {
        $this->cache_driver = $driver;
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
        /* Checks if the CacheInterface is already instantiated. */
        if (!$this->cache_driver instanceof CacheDriver) {
            $this->cache_driver = Cache::driver($this->getConfig('cache_driver'));

            $this->cache_driver->setConfig($this->getCacheConfig());
        }

        return $this->cache_driver;
    }

    /**
     * Gets the cache config vars
     *
     * @return array The cache config vars.
     */
    protected function getCacheConfig(): array
    {
        return $this->getConfig('cache') ?? [];
    }
}
