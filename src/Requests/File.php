<?php

namespace iArcadia\MagicPokeAPI\Requests;

use iArcadia\MagicPokeAPI\PokeAPI;

/**
 * HTTP requests builder with PHP default methods.
 *
 * @author Kévin Bibollet <bibollet.kevin@gmail.com>
 * @license MIT
 */
class File
{
    /**
     * Sends a HTML request and gets a data response.
     *
     * @param PokeAPI $api The API instance which called this method.
     *
     * @return string
     */
    public static function send(PokeAPI $api)
    {
        return file_get_contents($api->url());
    }
}