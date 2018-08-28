<?php

namespace Tests;

use Amber\Cache\CacheAware\CacheAwareClass;
use Amber\Cache\Driver\CacheDriver;
use Amber\Cache\Driver\JsonCache;
use Amber\Config\ConfigAwareTrait;
use PHPUnit\Framework\TestCase;

class CacheAwareTest extends TestCase
{
    public function testFileCache()
    {
        $cache = new class() extends CacheAwareClass {
            use ConfigAwareTrait;
        };

        $this->assertInstanceOf(CacheDriver::class, $cache->getCache());

        $driver = new JsonCache();

        $this->assertInstanceOf(JsonCache::class, $driver);

        $this->assertNull($cache->setCache($driver));

        $this->assertInstanceOf(CacheDriver::class, $cache->getCache());
        $this->assertInstanceOf(JsonCache::class, $cache->getCache());
    }
}
