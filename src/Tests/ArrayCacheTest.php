<?php

namespace Amber\Cache\Tests;

use Amber\Cache\ArrayCache;
use PHPUnit\Framework\TestCase;

class ArrayCacheTest extends TestCase
{
    public function testFileCache()
    {
        $cache = new ArrayCache();
        $key = 'key';
        $value = 'value';

        for ($x = 0; $x < 3; $x++) {
            $multiple[$key.$x] = $value.$x;
        }

        /* Checks if the filecache is correctly instantiated */
        $this->assertInstanceOf(
            ArrayCache::class,
            $cache
        );

        $this->assertTrue($cache->clear());

        $this->assertFalse($cache->has($key));

        $this->assertFalse($cache->set(1, $value));
        $this->assertTrue($cache->set($key, $value));

        $this->assertTrue($cache->has($key));

        $this->assertFalse($cache->get(1), $value);
        $this->assertSame($cache->get($key), $value);

        $this->assertSame($cache->get('unkwonKey', 'default'), 'default');

        $this->assertTrue($cache->delete($key));

        $this->assertTrue($cache->setMultiple($multiple, 15));

        $this->assertSame($cache->getMultiple(array_keys($multiple)), $multiple);

        $this->assertTrue($cache->deleteMultiple(array_keys($multiple)));
    }
}
