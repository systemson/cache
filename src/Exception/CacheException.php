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

use Psr\SimpleCache\CacheException as CacheExceptionInterface;

/**
 * Interface used for all types of exceptions thrown by the implementing library.
 */
class CacheException extends \Exception implements CacheExceptionInterface
{
}
