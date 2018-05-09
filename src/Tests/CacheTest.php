<?php

namespace Amber\Cache\Tests;

use Amber\Cache\Cache;
use Amber\Cache\Driver\FileCache;
use Amber\Cache\Driver\JsonCache;
use PHPUnit\Framework\TestCase;

class CacheTest extends TestCase
{
    public function testCache()
    {
        $json = new JsonCache();

        $this->assertInstanceOf(
            FileCache::class,
            Cache::getInstance()
        );

        $this->assertInstanceOf(
            JsonCache::class,
            Cache::driver($json)
        );

        $this->assertFalse(Cache::has('key'));
    }
}
