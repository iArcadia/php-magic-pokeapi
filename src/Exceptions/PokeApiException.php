<?php

namespace iArcadia\MagicPokeAPI\Exceptions;

use Exception;

/**
 * PokeAPI exception type.
 *
 * @author Kévin Bibollet <bibollet.kevin@gmail.com>
 * @license MIT
 *
 * @extends Exception
 */
class PokeApiException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}