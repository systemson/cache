<?php

namespace Amber\Cache\Tests;

use Amber\Cache\FileCache;
use Amber\Filesystem\Filesystem;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class FileCacheTest extends TestCase
{
    public function testFileCache()
    {
        $cache = new FileCache();
        $key = 'key';
        $value = 'value';

        for($x=0; $x < 3; $x++) {
            $multiple[$key.$x] = $value.$x;
        }

        /* Checks if the filecache is correctly instantiated */
        $this->assertInstanceOf(
            FileCache::class,
            $cache
        );

        $this->assertTrue($cache->clear());

        $this->assertFalse($cache->has($key));

        $this->assertTrue($cache->set($key, $value));

        $this->assertTrue($cache->has($key));

        $this->assertSame($cache->get($key), $value);

        $this->assertSame($cache->get('unkwonKey', 'default'), 'default');

        $this->assertTrue($cache->delete($key));


        $this->assertTrue($cache->setMultiple($multiple, 15));

        $this->assertSame($cache->getMultiple(array_keys($multiple)), $multiple);

        $this->assertTrue($cache->deleteMultiple(array_keys($multiple)));


        $content = Carbon::now()->subMinutes(15)."\r\n".serialize('value');

        Filesystem::put('tmp/cache/'.sha1('other_key'), $content);

        $this->assertTrue($cache->isExpired($cache->getCachedItem('other_key')));
    }
}
