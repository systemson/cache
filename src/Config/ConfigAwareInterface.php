<?php
/**
 * This file is part of the Amber/Cache package.
 *
 * @package Amber/Cache
 * @author Deivi Peña <systemson@gmail.com>
 * @license GPL-3.0-or-later
 * @license https://opensource.org/licenses/gpl-license GNU Public License
 */

namespace Amber\Cache\Config;

use Amber\Config\ConfigAwareInterface as BaseInterface;

/**
 * ConfigAware contract.
 */
interface ConfigAwareInterface extends BaseInterface
{
    const PACKAGE_NAME = 'cache';

    const FILE_CACHE_PATH = '/tmp/cache';
}
