<?php

namespace Amber\Cache\Tests;

use Amber\Cache\Driver\ApcuCache;
use Amber\Cache\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ApcuCacheTest extends TestCase
{
    public function testApcuCache()
    {
        if(!extension_loaded('apcu') || !ini_get('apc.enabled')) {

            $this->expectException(\Exception::class);

            $cache = new ApcuCache();
        }

        $cache = new ApcuCache();

        /* Sets the vars to test */
        $key = 'key';
        $value = 'value';

        for ($x = 0; $x < 3; $x++) {
            $multiple[$key.$x] = $value.$x;
        }

        /* Checks thay the driver is correctly instantiated */
        $this->assertInstanceOf(
            ApcuCache::class,
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

        /* Clears the cache after testing */
        $this->assertTrue($cache->clear());

        return $cache;
    }

    public function testGetException()
    {
        if(!extension_loaded('apcu') || !ini_get('apc.enabled')) {

            $this->expectException(\Exception::class);

            $cache = new ApcuCache();
        }

        $cache = new ApcuCache();

        $this->expectException(InvalidArgumentException::class);
        $cache->get(1);
    }

    public function testSetException()
    {
        if(!extension_loaded('apcu') || !ini_get('apc.enabled')) {

            $this->expectException(\Exception::class);

            $cache = new ApcuCache();
        }

        $cache = new ApcuCache();

        $this->expectException(InvalidArgumentException::class);
        $cache->set(1, 'value');
    }

    public function testHastException()
    {
        if(!extension_loaded('apcu') || !ini_get('apc.enabled')) {

            $this->expectException(\Exception::class);

            $cache = new ApcuCache();
        }

        $cache = new ApcuCache();

        $this->expectException(InvalidArgumentException::class);
        $cache->has(1);
    }

    public function testDeleteException()
    {
        if(!extension_loaded('apcu') || !ini_get('apc.enabled')) {

            $this->expectException(\Exception::class);

            $cache = new ApcuCache();
        }

        $cache = new ApcuCache();

        $this->expectException(InvalidArgumentException::class);
        $cache->delete(1);
    }
}
