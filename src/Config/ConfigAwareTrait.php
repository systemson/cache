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

use Amber\Config\ConfigAwareTrait as BaseConfig;

/**
 * ConfigAware implementation.
 */
trait ConfigAwareTrait
{
    use BaseConfig;

    /**
     * Gets file system base path.
     *
     * @return string The base path.
     */
    public function getBasePathConfig()
    {
        return $this->getConfig('base_path', getcwd());
    }
}
