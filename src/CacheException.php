<?php

namespace Amber\Cache;

use Psr\SimpleCache\CacheException as CacheExceptionInterface;

/**
 * Interface used for all types of exceptions thrown by the implementing library.
 */
class CacheException extends \Exception implements CacheExceptionInterface
{
}
