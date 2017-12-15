<?php

namespace iArcadia\MagicPokeAPI\Exceptions;

use Exception;

/**
 * PokeAPI exception type for file system.
 *
 * @author Kévin Bibollet <bibollet.kevin@gmail.com>
 * @license MIT
 *
 * @extends Exception
 */
class PokeApiFileException extends Exception
{
    /**
     * Constructor method.
     *
     * @param string $message The displayed error message.
     * @param int $code The error code.
     * @param Exception|null $previous The previous exception.
     */
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}