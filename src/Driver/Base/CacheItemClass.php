<?php
/**
 * This file is part of the Amber/Cache package.
 *
 * @package Amber/Cache
 * @author Deivi Peña <systemson@gmail.com>
 * @license GPL-3.0-or-later
 * @license https://opensource.org/licenses/gpl-license GNU Public License
 */

namespace Amber\Cache\Driver\Base;

use Carbon\Carbon;
use Psr\Cache\CacheItemInterface;

/**
 * This class is based on the PSR-6 CacheItemInterface but it's not a proper implementation.
 *
 * It's a future task to implement PSR-6 within this library, but it's not intended in the current stage
 * of this project.
 *
 * @todo Could be moved to it's own folder.
 * @todo Implement the PSR-6.
 */
class CacheItemClass implements CacheItemInterface
{
    /**
     * @var The item's key.
     */
    protected $key;

    /**
     * @var The item's value.
     */
    protected $value;

    /**
     * @var The item's time to live.
     */
    protected $ttl;

    /**
     * Instantiates a new Cache Item.
     *
     * @param string $key The Cache's key.
     * @param mixed $value The Cache's value.
     * @param mixed $ttl The Cache's time to live in minutes.
     */
    public function __construct($key, $value, $ttl = null)
    {
        $this->key = $key;
        $this->set($value);
        $this->expiresAt($ttl);
    }

    /**
     * Returns the key for the current cache item.
     *
     * @return string The key string for this cache item.
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Retrieves the value of the item from the cache associated with this object's key.
     *
     * @return mixed The value corresponding to this cache item's key, or null if not found.
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * Confirms if the cache item lookup resulted in a cache hit.
     *
     * @return bool True if the request resulted in a cache hit. False otherwise.
     */
    public function isHit()
    {
        return true;
    }

    /**
     * Sets the value represented by this cache item.
     *
     * @param mixed $value The serializable value to be stored.
     *
     * @return static The invoked object.
     */
    public function set($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Sets the expiration time for this cache item.
     *
     * @todo Should be implemented.
     *
     * @param \DateTimeInterface|null $expiration The point in time after which the item MUST be considered expired.
     *
     * @return static The called object.
     */
    public function expiresAt($expiration)
    {
        $this->ttl = $expiration;
        return $this;
    }

    /**
     * Sets the expiration time for this cache item.
     *
     * @param int|null $time The period of time from the present after which the item MUST be considered
     *   expired.
     *
     * @return static The called object.
     */
    public function expiresAfter($time)
    {
        $this->ttl = Carbon::now()->addSeconds($time);

        return $this;
    }

    /**
     * Returns the expiration time for this cache item.
     *
     * @return string The expiration time.
     */
    public function getExpiration()
    {
        return $this->ttl;
    }

    /**
     * Whether the item is expired.
     *
     * @return string The expiration time.
     */
    public function isExpired()
    {
        if ($this->getExpiration() && $this->getExpiration() <= Carbon::now()) {
            return true;
        }

        return false;
    }

    /**
     * Returns a string representation of the cached value.
     *
     * @return string The string representation of the value.
     */
    public function __toString()
    {
        return $this->value;
    }
}
