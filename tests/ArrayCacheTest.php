<?php

namespace Tests;

use Amber\Cache\Driver\ArrayCache;
use Amber\Cache\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ArrayCacheTest extends TestCase
{
    public function testArrayCache()
    {
        /* Instantiates the Cache driver */
        $cache = new ArrayCache();

        /* Sets the vars to test */
        $key = 'key';
        $value = 'value';

        $string = 'string';
        $integer = 1;
        $float = 1.1;
        $array = [1,2,3,4,5];

        $object = new \stdClass();
        $object->string = 'string';
        $object->integer = $integer;
        $object->array = $array;

        for ($x = 0; $x < 3; $x++) {
            $multiple[$key . $x] = $value . $x;
        }

        $multiple['string'] = $string;
        $multiple['integer'] = $integer;
        $multiple['float'] = $float;
        $multiple['array'] = $array;
        $multiple['object'] = $object;

        /* Checks thay the driver is correctly instantiated */
        $this->assertInstanceOf(
            ArrayCache::class,
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
        $this->assertSame($cache->get('unknownKey', 'default'), 'default');

        /* Deletes the item from cache */
        $this->assertTrue($cache->delete($key));

        /* Caches an array of items */
        $this->assertTrue($cache->setMultiple($multiple, 15));

        /* Gets the array of items */
        $this->assertSame($cache->getMultiple(array_keys($multiple)), $multiple);

        /* Tests single actions from a setMultiple */
        $this->assertTrue($cache->has('string'));
        $this->assertTrue($cache->has('integer'));
        $this->assertTrue($cache->has('float'));
        $this->assertTrue($cache->has('array'));
        $this->assertTrue($cache->has('object'));

        $this->assertEquals($cache->get('string'), $string);
        $this->assertEquals($cache->get('integer'), $integer);
        $this->assertEquals($cache->get('float'), $float);
        $this->assertEquals($cache->get('array'), $array);
        $this->assertEquals($cache->get('object'), $object);

        $this->assertTrue($cache->delete('string'));
        $this->assertTrue($cache->delete('integer'));
        $this->assertTrue($cache->delete('float'));
        $this->assertTrue($cache->delete('array'));
        $this->assertTrue($cache->delete('object'));

        /* Deletes the array of items from the cache */
        $this->assertTrue($cache->deleteMultiple(array_keys($multiple)));

        /* Clears the cache after testing */
        $this->assertTrue($cache->clear());

        return $cache;
    }

    /**
     * @depends testArrayCache
     */
    public function testGetException($cache)
    {
        $this->expectException(InvalidArgumentException::class);
        $cache->get(1);
    }

    /**
     * @depends testArrayCache
     */
    public function testSetException($cache)
    {
        $this->expectException(InvalidArgumentException::class);
        $cache->set(1, 'value');
    }

    /**
     * @depends testArrayCache
     */
    public function testHastException($cache)
    {
        $this->expectException(InvalidArgumentException::class);
        $cache->has(1);
    }

    /**
     * @depends testArrayCache
     */
    public function testDeleteException($cache)
    {
        $this->expectException(InvalidArgumentException::class);
        $cache->delete(1);
    }
}
