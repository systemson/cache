<?php

namespace Tests;

use Amber\Cache\CacheAware\CacheAwareTrait;
use Amber\Cache\Driver\CacheDriver;
use Amber\Cache\Driver\SimpleCache;
use PHPUnit\Framework\TestCase;

class CacheAwareTest extends TestCase
{
    public function testFileCache()
    {
        $cache = $this->getMockForTrait(CacheAwareTrait::class);

        $driver = new SimpleCache();

        $this->assertInstanceOf(CacheDriver::class, $driver);

        $this->assertNull($cache->setCache($driver));

        $this->assertInstanceOf(CacheDriver::class, $cache->getCache());
    }
}
