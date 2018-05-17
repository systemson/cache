<?php

namespace Amber\Cache\Tests;

use Amber\Cache\Driver\SimpleCache;
use Amber\Cache\Exception\InvalidArgumentException;
use Amber\Filesystem\Filesystem;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class SimpleCacheTest extends TestCase
{
    public function testFileCache()
    {
        /* Instantiates the Cache driver */
        $cache = new SimpleCache();

        /* Sets the vars to test */
        $key = 'key';
        $value = 'value';

        for ($x = 0; $x < 3; $x++) {
            $multiple[$key.$x] = $value.$x;
        }

        /* Checks thay the driver is correctly instantiated */
        $this->assertInstanceOf(
            SimpleCache::class,
            $cache
        );

        /* Clears the cache before testing */
        $this->assertTrue($cache->clear());

        /* Checks for an unexistent key */
        $this->assertFalse($cache->has($key));

        /* Caches an item */
        $this->assertTrue($cache->set($key, $value));

        /* Checks if that item exists in the cache */
        $this->assertTrue($cache->has($key));

        /* Gets the item from cache */
        $this->assertSame($cache->get($key), $value);

        /* Checks for an inexistent key adding a default param */
        /* Must return the default value */
        $this->assertSame($cache->get('unkwonKey', 'default'), 'default');

        /* Deletes the item from cache */
        $this->assertTrue($cache->delete($key));

        /* Caches an array of items */
        $this->assertTrue($cache->setMultiple($multiple, 15));

        /* Gets the array of items */
        $this->assertSame($cache->getMultiple(array_keys($multiple)), $multiple);

        /* Deletes the array of items from the cache */
        $this->assertTrue($cache->deleteMultiple(array_keys($multiple)));

        /* Sets the content for a expired cache item */
        $content = Carbon::now()->subMinutes(15)."\r\n".serialize('value');

        /* Writes the expired item into the cache filesystem */
        Filesystem::put('tmp/cache/'.sha1('other_key'), $content);

        /* Validates that the item is expired */
        $this->assertTrue($cache->isExpired($cache->getCachedItem('other_key')));

        /* Clears the cache after testing */
        $this->assertTrue($cache->clear());

        return $cache;
    }

    /**
     * @depends testFileCache
     */
    public function testGetException($cache)
    {
        $this->expectException(InvalidArgumentException::class);
        $cache->get(1);
    }

    /**
     * @depends testFileCache
     */
    public function testSetException($cache)
    {
        $this->expectException(InvalidArgumentException::class);
        $cache->set(1, 'value');
    }

    /**
     * @depends testFileCache
     */
    public function testHastException($cache)
    {
        $this->expectException(InvalidArgumentException::class);
        $cache->has(1);
    }

    /**
     * @depends testFileCache
     */
    public function testDeleteException($cache)
    {
        $this->expectException(InvalidArgumentException::class);
        $cache->delete(1);
    }
}
