<?php

namespace iArcadia\MagicPokeAPI\Requests;

use iArcadia\MagicPokeAPI\PokeAPI;

/**
 * HTTP requests builder with PHP default methods.
 *
 * @author Kévin Bibollet <bibollet.kevin@gmail.com>
 * @license MIT
 */
class File extends Request
{
    /**
     * Sends a HTML request and gets a data response.
     *
     * @param string $url
     *
     * @return string
     */
    public static function send(string $url): string
    {
        return file_get_contents($url);
    }
}