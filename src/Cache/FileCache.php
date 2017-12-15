<?php

namespace iArcadia\MagicPokeAPI\Cache;

use iArcadia\MagicPokeAPI\PokeAPI;
use Symfony\Component\Yaml\Yaml;

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
    protected static function getFileName(string $url)
    {
        return md5($url);
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
        
        return "{$path}/magicpokeapi";
    }
    
    /**
     * Gets the storage image directory for the caching system.
     *
     * @param PokeAPI $api The API instance which called this method;
     *
     * @return string
     */
    protected static function getImageDirectory(PokeAPI $api)
    {
        $path = PokeAPI::config('cache.FileCache::storage_path');
        
        if (!file_exists($path)) { mkdir($path); }
        if (!file_exists("{$path}/magicpokeapi/images")) { mkdir("{$path}/magicpokeapi/images"); }
        
        return "{$path}/magicpokeapi/images";
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
        $fileName = self::getFileName($api->url);
        $dir = self::getDirectory($api);
        $ext = PokeAPI::config('cache.FileCache::ext');
        
        return "{$dir}/{$fileName}.{$ext}";
    }
    
    /**
     * Gets the relative path of the image file.
     *
     * @param PokeAPI $api The API instance which called this method.
     * @param string $imageURL The image URL got from server.
     *
     * @return string
     */
    protected static function getImagePath(PokeAPI $api, string $imageURL)
    {
        $fileName = self::getFileName($imageURL);
        $dir = self::getImageDirectory($api);
        
        return "{$dir}/{$fileName}.png";
    }
    
    /**
     * Gets content of already cached data.
     *
     * @param PokeAPI $api The API instance which called this method.
     *
     * @return object|null
     */
    public static function get(PokeAPI $api)
    {
        $file = self::getFilePath($api);
        $data = null;
        
        if (file_exists($file))
        {
            if (filemtime($file) + PokeAPI::config('cache.expiration_time') < time()
                || $api->cacheForcing())
            {
                unlink($file);
            }
            else
            {
                $data = file_get_contents($file);
                
                switch (PokeAPI::config('cache.FileCache::ext'))
                {
                    case 'json': $data = self::parseJson($data); break;
                    case 'yaml': $data = self::parseYaml($data); break;
                }
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
    public static function cache(PokeAPI $api, &$data)
    {
        $file = self::getFilePath($api);
        
        self::cacheImages($api, $data);
        
        switch (PokeAPI::config('cache.FileCache::ext'))
        {
            case 'json': $data = self::cacheJson($data); break;
            case 'yaml': $data = self::cacheYaml($data); break;
        }
        
        return file_put_contents($file, $data);
    }
    
    /**
     * Clears the cache directory.
     */
    public static function clear()
    {
        $path = PokeAPI::config('cache.FileCache::storage_path');
        
        if (!file_exists($path)) { mkdir($path); }
        else
        {
            self::recursiveClear($path);
            mkdir($path);
        }
    }
    
    /**
     * Navigates through children directories to delete files from a starting point.
     *
     * @param string $start The starting directory.
     *
     * @return bool
     */
    protected static function recursiveClear(string $start)
    {
        $files = array_diff(scandir($start), array('.','..')); 
            
        foreach ($files as $file)
        { 
            (is_dir("$start/$file")) ? self::recursiveClear("$start/$file") : unlink("$start/$file"); 
        } 

        return rmdir($start); 
    }
    
    /**
     * Copies image files in cache.
     *
     * @param PokeAPI $api The API instance which called this method.
     * @param string $data The data got from the server.
     */
    protected static function cacheImages(PokeAPI $api, string &$data)
    {
        foreach (self::searchForImages($api, $data) as $url)
        {
            $file = self::getImagePath($api, $url);
            $image = $api->RequestSystem()::sendByUrl($url);
            
            file_put_contents($file, $image);
        }
    }
    
    /**
     * Navigates through data to find image URLs and places them into an array.
     *
     * @param PokeAPI $api The API instance which called this method.
     * @param string $data The data got from the server.
     *
     * @return array
     */
    protected static function searchForImages(PokeAPI $api, &$data)
    {
        $images = [];
        
        if (is_string($data)) { $data = json_decode($data); }
        
        foreach($data as &$item)
        {
            if (is_object($item) || is_array($item))
            {
                $images = array_merge($images, self::searchForImages($api, $item));
            }
            else if (preg_match('/.+\.(?:png)|(?:jpg)|(?:jpeg)/', $item))
            {
                array_push($images, $item);
                $item = self::getImagePath($api, $item);
            }
        }
        
        return $images;
    }
    
    /**
     * Converts JSON string to PHP object.
     *
     * @param string $data The JSON string of data.
     *
     * @return stdClass
     */
    protected static function parseJson(string $data)
    {
        return json_decode($data);
    }
    
    /**
     * Converts YAML string to PHP object.
     *
     * @param string $data The YAML string of data.
     *
     * @return stdClass
     */
    protected static function parseYaml(string $data)
    {
        return Yaml::parse($data);
    }
    
    /**
     * Converts data into JSON string.
     *
     * @param mixed $data The data.
     *
     * @return string
     */
    protected static function cacheJson($data)
    {
        if (!is_string($data)) { $data = json_encode($data); }
        
        return $data;
    }
    
    /**
     * Converts data into YAML string.
     *
     * @param mixed $data The data.
     *
     * @return string
     */
    protected static function cacheYaml($data)
    {
        if (is_string($data)) { $data = json_decode($data); }
        
        if (is_array($data)) { $data = Yaml::dump($data); }
        if (is_object($data)) { $data = Yaml::dump($data, 2, 4, Yaml::DUMP_OBJECT); }
        
        return $data;
    }
}