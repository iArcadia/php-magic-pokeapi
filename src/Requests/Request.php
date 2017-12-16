<?php

namespace iArcadia\MagicPokeAPI\Requests;

use iArcadia\MagicPokeAPI\Requests\CURL;
use iArcadia\MagicPokeAPI\Requests\File;

use iArcadia\MagicPokeAPI\Helpers\Config;
use iArcadia\MagicPokeAPI\Helpers\Constant;

/**
 * Wraps all request system classes.
 *
 * @author Kévin Bibollet <bibollet.kevin@gmail.com>
 * @license MIT
 */
class Request
{
    /**
     * Gets the class of the used request system.
     *
     * @return string
     */
    protected static function getSystemClass(): string
    {
        $system = Config::get('request.system');
        return 'iArcadia\\MagicPokeAPI\\Requests\\' . Constant::REQUEST_CLASSES[$system];
    }
    
    /**
     * Sends a HTML request and gets a data response.
     *
     * @param string $url
     *
     * @return string
     */
    public static function send(string $url): string
    {
        $class = self::getSystemClass();
        
        return $class::send($url);
    }
}