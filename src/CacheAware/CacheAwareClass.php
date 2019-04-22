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

/**
 * CacheAware abstract class.
 */
abstract class CacheAwareClass implements CacheAwareInterface
{
    use CacheAwareTrait;
}
