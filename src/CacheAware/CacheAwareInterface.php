<?php
/**
 * This file is part of the Amber/Cache package.
 *
 * @package Amber/Cache
 * @author Deivi Peña <systemson@gmail.com>
 * @license GPL-3.0-or-later
 * @license https://opensource.org/licenses/gpl-license GNU Public License
 */

namespace Amber\Cache\CacheAware;

use Amber\Cache\Driver\CacheDriver;
use Amber\Config\ConfigAwareInterface;

/**
 * CacheAware contract.
 */
interface CacheAwareInterface extends ConfigAwareInterface
{
    const CACHE_DRIVER = 'file';

    /**
     * Sets the cache driver.
     *
     * @param CacheDriver $driver An instance of the cache driver.
     *
     * @return void
     */
    public function setCache(CacheDriver $driver);

    /**
     * Gets the cache driver.
     *
     * @param CacheDriver $driver An instance of the cache driver.
     *
     * @return CacheDriver The stored cache driver.
     */
    public function getCache(): CacheDriver;
}
