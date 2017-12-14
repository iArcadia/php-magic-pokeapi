<?php

namespace iArcadia\MagicPokeAPI\Cache;

use iArcadia\MagicPokeAPI\PokeAPI;

/**
 * All file caching related methods.
 *
 * @author Kévin Bibollet <bibollet.kevin@gmail.com>
 * @license MIT
 */
class FileCache
{
    /**
     * Gets a MD5-hashed name from an URL.
     *
     * @param PokeAPI $api The API instance which called this method.
     *
     * @return string
     */
    protected static function getFileName(PokeAPI $api)
    {
        return md5($api->url());
    }
    
    /**
     * Gets the storage directory for the caching system.
     *
     * @param PokeAPI $api The API instance which called this method;
     *
     * @return string
     */
    protected static function getDirectory(PokeAPI $api)
    {
        $path = PokeAPI::config('cache.FileCache::storage_path');
        
        if (!file_exists($path)) { mkdir($path); }
        if (!file_exists("{$path}/magicpokeapi")) { mkdir("{$path}/magicpokeapi"); }
        if (!file_exists("{$path}/magicpokeapi/{$api->resource()}")) { mkdir("{$path}/magicpokeapi/{$api->resource()}"); }
        
        return "{$path}/magicpokeapi/{$api->resource()}";
    }
    
    /**
     * Gets the relative path of the file.
     *
     * @param PokeAPI $api The API instance which called this method.
     *
     * @return string
     */
    protected static function getFilePath(PokeAPI $api)
    {
        $fileName = self::getFileName($api);
        $dir = self::getDirectory($api);
        
        return "{$dir}/{$fileName}.json";
    }
    
    /**
     * Gets content of already cached data.
     *
     * @param PokeAPI $api The API instance which called this method.
     *
     * @return string|null
     */
    public static function get(PokeAPI $api)
    {
        $file = self::getFilePath($api);
        $data = null;
        
        if (file_exists($file))
        {
            if (filemtime($file) + PokeAPI::config('cache.expiration_time') < time())
            {
                unlink($file);
            }
            else
            {
                $data = file_get_contents($file);
            }
        }
        
        return $data;
    }
    
    /**
     * Creates a file which will store given data.
     *
     * @param PokeAPI $api The API instance which called this method.
     * @param string $data The given data.
     *
     * @return boolean
     */
    public static function cache(PokeAPI $api, $data)
    {
        $file = self::getFilePath($api);
        
        return file_put_contents($file, $data);
    }
    
    /*protected function clearCache(string $dir)
    {
        if (file_exists('cache'))
        {
            $this->deleteDirectory('cache');
        }
    }
    
    protected function deleteDirectory(string $dir)
    {
        $files = array_diff(scandir($dir), array('.','..')); 
            
        foreach ($files as $file)
        { 
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
        } 

        return rmdir($dir); 
    }*/
}