<?php

namespace Amber\Cache\CacheAware;

use Amber\Cache\Cache;
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
        /* Checks if the CacheInterface is already instantiated. */
        if (!$this->cacheDriver instanceof CacheDriver) {
            $this->cacheDriver = Cache::driver($this->getConfig('cache_driver'));

            $this->cacheDriver->setConfig($this->getCacheConfig());
        }

        return $this->cacheDriver;
    }

    /**
     * Gets the cache config vars
     *
     * The config cache vars must be set in a array by the key 'cache' containing the cache vars inside. Like this
     *      $configs = [
     *          'cache' => [
     *              'cache_driver' => 'file',
     *          ],
     *      ];
     *
     * @return array The cache config vars.
     */
    public function getCacheConfig()
    {
        return $this->getConfig('cache') ?? [];
    }
}
