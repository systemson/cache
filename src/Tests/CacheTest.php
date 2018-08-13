<?php

namespace Amber\Cache\Tests;

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

        if (!extension_loaded('apcu') || !ini_get('apc.enabled')) {
            $this->expectException(\Exception::class);

            Cache::driver('apcu');

            return;
        } else {
            $this->assertInstanceOf(
                ApcuCache::class,
                Cache::driver('apcu')
            );
        }
    }

    public function testCacheConfig()
    {
        $config = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        $this->assertNull(Cache::reset());

        $this->assertInstanceOf(
            SimpleCache::class,
            Cache::config($config)
        );

        $this->assertInstanceOf(
            SimpleCache::class,
            Cache::config($config)
        );
    }

    public function testException()
    {
        $this->expectException(InvalidArgumentException::class);

        Cache::driver(UnknownClass::class);
    }
}
