<?php

namespace Tests;

use Amber\Cache\Cache;
use Amber\Cache\Driver\ApcuCache;
use Amber\Cache\Driver\ArrayCache;
use Amber\Cache\Driver\JsonCache;
use Amber\Cache\Driver\SimpleCache;
use Amber\Cache\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CacheTest extends TestCase
{
    public function testCache()
    {
        $this->assertInstanceOf(
            SimpleCache::class,
            Cache::getInstance()
        );

        $this->assertInstanceOf(
            SimpleCache::class,
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
            SimpleCache::class,
            Cache::driver(SimpleCache::class)
        );

        $this->assertFalse(Cache::has('key'));

        if (!extension_loaded('apcu') || !ini_get('apc.enabled') || (ApcuCache::isCli() && !ini_get('apc.enable_cli'))) {
            $this->expectException(\Exception::class);

            $cache = new ApcuCache();
        } else {
            $this->assertInstanceOf(
                ApcuCache::class,
                Cache::driver('apcu')
            );
        }
    }

    public function testException()
    {
        $this->expectException(InvalidArgumentException::class);

        Cache::driver(UnknownClass::class);
    }
}
