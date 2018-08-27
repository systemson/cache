<?php

namespace Tests;

use Amber\Cache\CacheAware\CacheAwareClass;
use Amber\Cache\Driver\CacheDriver;
use Amber\Cache\Driver\SimpleCache;
use PHPUnit\Framework\TestCase;

class CacheAwareTest extends TestCase
{
    public function testFileCache()
    {
        $cache = $this->getMockForAbstractClass(CacheAwareClass::class);

        $this->assertInstanceOf(CacheDriver::class, $cache->getCache('json'));

        $driver = new SimpleCache();

        $this->assertInstanceOf(CacheDriver::class, $driver);

        $this->assertNull($cache->setCache($driver));

        $this->assertInstanceOf(CacheDriver::class, $cache->getCache());
    }
}
