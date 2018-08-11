<?php

namespace Amber\Cache\Config;

use Amber\Config\ConfigAware as BaseConfig;

trait ConfigAware
{
    use BaseConfig;

    public function getBasePathConfig()
    {
        return $this->getConfig('base_path', getcwd());
    }

    public function getBaseFolderConfig()
    {
        return $this->getConfig('cache_path', '/tmp/cache');
    }
}
