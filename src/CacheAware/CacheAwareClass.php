<?php

namespace Amber\Cache\CacheAware;

use Amber\Config\ConfigAwareTrait;

abstract class CacheAwareClass implements CacheAwareInterface
{
    use CacheAwareTrait;
}
