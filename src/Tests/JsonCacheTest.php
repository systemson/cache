<?php

namespace Amber\Cache\Tests;

use Amber\Cache\Driver\JsonCache;
use Amber\Filesystem\Filesystem;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class JsonCacheTest extends TestCase
{
    public function testJsonCache()
    {
        $cache = new JsonCache();
        $key = 'key';
        $value = 'value';

        for ($x = 0; $x < 3; $x++) {
            $multiple[$key.$x] = $value.$x;
        }

        /* Checks if the filecache is correctly instantiated */
        $this->assertInstanceOf(
            JsonCache::class,
            $cache
        );

        $this->assertTrue($cache->clear());

        $this->assertFalse($cache->has($key));

        $this->assertTrue($cache->set($key, $value));

        $this->assertTrue($cache->has($key));

        $this->assertSame($cache->get($key), json_encode($value));

        $this->assertSame($cache->get('unkwonKey', 'default'), json_encode('default'));

        $this->assertTrue($cache->delete($key));

        $this->assertTrue($cache->setMultiple($multiple, 15));

        $this->assertSame($cache->getMultiple(array_keys($multiple)), array_map(
            function ($value) {
                return json_encode($value);
            }, $multiple
        ));

        $this->assertTrue($cache->deleteMultiple(array_keys($multiple)));

        $content = Carbon::now()->subMinutes(15)."\r\n".serialize('value');

        Filesystem::put('tmp/cache/'.sha1('other_key'), $content);

        $this->assertTrue($cache->isExpired($cache->getCachedItem('other_key')));
    }
}
