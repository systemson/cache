<?php

namespace Amber\Cache;

use Psr\SimpleCache\InvalidArgumentException as Interface;

/**
 * Exception interface for invalid cache arguments.
 *
 * When an invalid argument is passed it must throw an exception which implements
 * this interface
 */
class InvalidArgumentException implements Interface
{
}
