<?php

namespace iArcadia\MagicPokeAPI\Helpers;

use iArcadia\MagicPokeAPI\Helpers\Config;
use iArcadia\MagicPokeAPI\Exceptions\PokeApiFileException;

/**
 * Gathers all language related methods.
 *
 * @author Kévin Bibollet <bibollet.kevin@gmail.com>
 * @license MIT
 */
class Lang
{
    /**
     * Gets values from a language file.
     *
     * Navigate through arrays with ".", "/", " " or "->".
     * Like "file.myarray" or "cache->file->ext".
     *
     * @param string $search
     *
     * @return mixed
     */
    public static function get(string $search)
    {
        $path = explode('.', $search);
        
        if (sizeof($path) === 1) { $path = explode('/', $search); }
        if (sizeof($path) === 1) { $path = explode(' ', $search); }
        if (sizeof($path) === 1) { $path = explode('->', $search); }
        
        $file = $path[0];
        array_shift($path);
        $keys = $path;
        $result = null;
        
        if (file_exists(dirname(__DIR__) . "/lang/{$file}.php"))
        {
            $result = require dirname(__DIR__) . "/lang/{$file}.php";
            
            if (!empty($keys))
            {
                foreach ($keys as $key)
                {
                    if (isset($result[$key])) { $result = $result[$key]; }
                    else { $result = null; break; }
                }
            }
        }
        else
        {
            throw new PokeApiFileException('Impossible to get the wanted translation because ' . dirname(__DIR__) .  "/lang/{$file}.php does not exist.", 500);
        }
        
        return $result;
    }
    
    /**
     * Searches through all translations.
     *
     * @param string $file
     * @param string $search
     *
     * @return mixed
     */
    public static function search(string $file, string $search)
    {
        $langs = array_keys(self::get($file));
        
        foreach ($langs as $lang)
        {
            $trans = self::get("{$file}.{$lang}.{$search}");
            
            if ($trans)
            {
                return $trans;
                break;
            }
        }
        
        return null;
    }
    
    /**
     * Checks if the automatic translation is active.
     *
     * @return bool
     */
    public static function isUsed(): bool
    {
        return Config::get('lang.use');
    }
}