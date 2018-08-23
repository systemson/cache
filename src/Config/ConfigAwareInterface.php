<?php

namespace Amber\Cache\Config;

use Amber\Config\ConfigAwareInterface as BaseInterface;

interface ConfigAwareInterface extends BaseInterface
{
    const FILE_CACHE_PATH = '/tmp/cache';
}