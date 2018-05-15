<?php

namespace Amber\Cache\Tests;

use Amber\Cache\Driver\ApcuCache;
use PHPUnit\Framework\TestCase;

class ApcuCacheTest extends TestCase
{
    public function testApcuCache()
    {

            $cache = new ApcuCache();
            $key = 'key';
            $value = 'value';

            for ($x = 0; $x < 3; $x++) {
                $multiple[$key.$x] = $value.$x;
            }

            /* Checks if the filecache is correctly instantiated */
            $this->assertInstanceOf(
                ApcuCache::class,
                $cache
            );

        if(extension_loaded('apcu') && ini_get('apc.enabled')) {

            $this->assertTrue($cache->clear());

            $this->assertFalse($cache->has(1));
            $this->assertFalse($cache->has($key));

            $this->assertFalse($cache->set(1, $value));
            $this->assertTrue($cache->set($key, $value));

            $this->assertTrue($cache->has($key));

            $this->assertFalse($cache->get(1), $value);
            $this->assertSame($cache->get($key), $value);

            $this->assertSame($cache->get('unkwonKey', 'default'), 'default');

            $this->assertFalse($cache->delete(1));
            $this->assertTrue($cache->delete($key));

            $this->assertTrue($cache->setMultiple($multiple, 15));

            $this->assertSame($cache->getMultiple(array_keys($multiple)), $multiple);

            $this->assertTrue($cache->deleteMultiple(array_keys($multiple)));
        }
    }
}
