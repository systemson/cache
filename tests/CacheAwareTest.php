<?php

namespace Tests;

use Amber\Cache\CacheAware\CacheAwareClass;
use Amber\Cache\Driver\CacheDriver;
use Psr\SimpleCache\CacheInterface;
use Amber\Cache\Driver\JsonCache;
use PHPUnit\Framework\TestCase;

class CacheAwareTest extends TestCase
{
    public function testFileCache()
    {
        $cache = new class() extends CacheAwareClass {};

        $driver = new JsonCache(__DIR__);

        $this->assertInstanceOf(JsonCache::class, $driver);

        $this->assertNull($cache->setCache($driver));

        $this->assertInstanceOf(JsonCache::class, $cache->getCache());
    }
}
