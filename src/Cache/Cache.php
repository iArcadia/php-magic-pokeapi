<?php

namespace iArcadia\MagicPokeAPI\Cache;

use iArcadia\MagicPokeAPI\Cache\File;

use iArcadia\MagicPokeAPI\Helpers\Config;
use iArcadia\MagicPokeAPI\Helpers\Constant;
use stdClass;

/**
 * Wraps all cache system classes.
 *
 * @author Kévin Bibollet <bibollet.kevin@gmail.com>
 * @license MIT
 */
class Cache
{
    /**
     * Gets the class of the used cache system.
     *
     * @return string
     */
    protected static function getSystemClass(): string
    {
        $system = Config::get('cache.system');
        return 'iArcadia\\MagicPokeAPI\\Cache\\' . Constant::CACHE_CLASSES[$system];
    }
    
    /**
     * Gets content of already cached data.
     *
     * @param string $url
     *
     * @return object|null
     */
    public static function get(string $url): ?stdClass
    {
        $class = self::getSystemClass();
        
        return $class::get($url);
    }
    
    /**
     * Caches data.
     *
     * @param string $url
     * @param string $data The given data.
     *
     * @return boolean
     */
    public static function cache(string $url, string &$data): bool
    {
        $class = self::getSystemClass();
        
        return $class::cache($url, $data);
    }
    
    /**
     * Clears the cache directory.
     */
    public static function clear()
    {
        $class = self::getSystemClass();
        
        return $class::cache();
    }
}