<?php
/**
 * This file is part of the Amber/Cache package.
 *
 * @package Amber/Cache
 * @author Deivi Peña <systemson@gmail.com>
 * @license GPL-3.0-or-later
 * @license https://opensource.org/licenses/gpl-license GNU Public License
 */

namespace Amber\Cache\Exception;

use Psr\SimpleCache\InvalidArgumentException as ExceptionInterface;

/**
 * Exception interface for invalid cache arguments.
 *
 * When an invalid argument is passed it must throw an exception which implements
 * this interface
 */
class InvalidArgumentException extends \InvalidArgumentException implements ExceptionInterface
{
    public static function mustBeString()
    {
        throw new self('Key argument must be a non empty string.');
    }

    public static function mustBeClass(string $key)
    {
        throw new self("Argument \"{$key}\" must be a valid class.");
    }

    public static function mustBeInstanceOf(string $class)
    {
        throw new self("Argument provided is not an instance of {$class}");
    }
}
