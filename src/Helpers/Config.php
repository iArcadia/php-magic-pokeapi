<?php

namespace iArcadia\MagicPokeAPI\Helpers;

use iArcadia\MagicPokeAPI\Exceptions\PokeApiFileException;

/**
 * Gathers all configuration related methods.
 *
 * @author Kévin Bibollet <bibollet.kevin@gmail.com>
 * @license MIT
 */
class Config
{
    /**
     * Gets values from a configuration file.
     *
     * Navigate through arrays with ".", "/", " " or "->".
     * Like "file.myarray" or "cache->file->ext".
     *
     * @param string $config Where to search.
     *
     * @return mixed
     */
    public static function get(string $config)
    {
        $path = explode('.', $config);
        
        if (sizeof($path) === 1) { $path = explode('/', $config); }
        if (sizeof($path) === 1) { $path = explode(' ', $config); }
        if (sizeof($path) === 1) { $path = explode('->', $config); }
        
        $file = $path[0];
        array_shift($path);
        $keys = $path;
        $result = null;
        
        if (file_exists(dirname(__DIR__) . "/config/{$file}.php"))
        {
            $result = require dirname(__DIR__) . "/config/{$file}.php";
            
            if (!empty($keys))
            {
                foreach ($keys as $key)
                {
                    if (isset($result[$key])) { $result = $result[$key]; }
                    else { break; }
                }
            }
        }
        else
        {
            throw new PokeApiFileException('Impossible to get the wanted configuration because ' . dirname(__DIR__) .  "/config/{$file}.php does not exist.", 500);
        }
        
        return $result;
    }
}