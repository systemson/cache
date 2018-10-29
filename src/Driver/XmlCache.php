<?php

namespace Amber\Cache\Driver;

use Amber\Cache\Driver\Base\FileCache;
use SimpleXMLElement;

class XmlCache extends FileCache
{
    /**
     * Get an item from the cache.
     *
     * @param string $key     The cache key.
     * @param mixed  $default Return value if the key does not exist.
     *
     * @throws \InvalidArgumentException
     *
     * @return mixed The cache value, or $default.
     */
    public function get($key, $default = null)
    {
        return $this->getRaw($key) ?? $this->toXml($default);
    }

    /**
     * Store the cache item in the file system.
     *
     * @param string    $key   The key of the cache item.
     * @param mixed     $value The value of the item to store.
     * @param null|int| $ttl   Optional. The TTL value of this item.
     *
     * @throws \InvalidArgumentException
     *
     * @return bool True on success and false on failure.
     */
    public function set($key, $value, $ttl = null)
    {
        return $this->setRaw([$this, 'toXml'], $key, $value, $ttl);
    }

    protected function toXml($value, $parent = 'root')
    {
        $xml = new SimpleXMLElement("<{$parent}></{$parent}>");

        if (is_iterable($value)) {
            array_walk_recursive($value, [$xml, 'addChild']);
        } elseif (is_string($value)) {
            $xml->addChild('', $value);
        }

        return $xml->asXML();
    }

    /**
     * Returns a json response.
     *
     * @param string $key The key of the cache item.
     *
     * @throws \InvalidArgumentException
     *
     * @return string echoes the cache value
     */
    public function response($key)
    {
        header('Content-Type: application/json');

        echo $this->get($key);
    }
}
