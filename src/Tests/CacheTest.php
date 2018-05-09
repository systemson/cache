<?php

namespace Amber\Cache\Tests;

use Amber\Cache\Cache;
use Amber\Cache\Driver\ApcuCache;
use Amber\Cache\Driver\ArrayCache;
use Amber\Cache\Driver\FileCache;
use Amber\Cache\Driver\JsonCache;
use Amber\Cache\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CacheTest extends TestCase
{
    public function testCache()
    {
        $this->assertInstanceOf(
            FileCache::class,
            Cache::getInstance()
        );

        $this->assertInstanceOf(
            FileCache::class,
            Cache::driver('file')
        );

        $this->assertInstanceOf(
            JsonCache::class,
            Cache::driver('json')
        );

        $this->assertInstanceOf(
            ArrayCache::class,
            Cache::driver('array')
        );

        $this->assertInstanceOf(
            ApcuCache::class,
            Cache::driver('apcu')
        );

        $this->assertInstanceOf(
            FileCache::class,
            Cache::driver(FileCache::class)
        );

        $this->assertFalse(Cache::has('key'));
    }

    public function testException()
    {
        $this->expectException(InvalidArgumentException::class);

        Cache::driver(UnknownClass::class);
    }
}
