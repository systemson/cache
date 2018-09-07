<?php

namespace Amber\Cache\Config;

use Amber\Config\ConfigAwareTrait as BaseConfig;

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
