<?php

use iArcadia\MagicPokeAPI\PokeAPI;
use iArcadia\MagicPokeAPI\Errors\ErrorMessage;
use iArcadia\MagicPokeAPI\Helpers\Config;
use iArcadia\MagicPokeAPI\Helpers\Lang;

if (!function_exists('magicpokeapi_config'))
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
    function magicpokeapi_config(string $config)
    {
        return Config::get($config);
    }
}

if (!function_exists('magicpokeapi_lang'))
{
    /**
     * Gets values from a language file.
     *
     * Navigate through arrays with ".", "/", " " or "->".
     * Like "file.myarray" or "cache->file->ext".
     *
     * @param string $search Where to search.
     *
     * @return mixed
     */
    function magicpokeapi_lang(string $search)
    {
        return Lang::get($search);
    }
}

if (!function_exists('magicpokeapi_lang_search'))
{
    /**
     * Gets values from a language file.
     *
     * Navigate through arrays with ".", "/", " " or "->".
     * Like "file.myarray" or "cache->file->ext".
     *
     * @param string $search Where to search.
     *
     * @return mixed
     */
    function magicpokeapi_lang_search(string $file, string $search)
    {
        return Lang::search($file, $search);
    }
}

if (!function_exists('magicpokeapi_get'))
{
    /**
     * Gets endpoint data from the API server.
     *
     * @param string $resource
     * @param int $limit
     * @param int $offset
     *
     * @return stdClass
     */
    function magicpokeapi_get(string $resource, int $limit = 20, int $offset = 0): stdClass
    {
        $api = new PokeAPI;
        
        $data = $api->resource($resource)
            ->limit($limit)
            ->offset($offset)
            ->get();
        
        unset($api);
        
        return $data;
    }
}

if (!function_exists('magicpokeapi_find'))
{
    /**
     * Gets resource data from the API server.
     *
     * @param string $resource
     * @param string|int $search
     *
     * @return stdClass
     */
    function magicpokeapi_find(string $resource, $search): stdClass
    {
        if (!is_string($search) && !is_int($search)) { throw new TypeError(ErrorMessage::TypeError(2, 'string or int')); }
        
        $api = new PokeAPI;
        
        $data = $api->resource($resource)
            ->find($search);
        
        unset($api);
        
        return $data;
    }
}

if (!function_exists('magicpokeapi_raw'))
{
    /**
     * Gets data from the API server.
     *
     * @return array|stdClass
     */
    function magicpokeapi_raw(...$urls)
    {
        $api = new PokeAPI;
        $data = null;
        
        if (sizeof($urls) === 1) { $data = $api->raw($urls[0]); }
        else if (sizeof($urls) > 1)
        {
            $data = [];
            
            foreach ($urls as $url)
            {
                $data[] = $api->get(null, $url);
            }
        }
        
        unset($api);
        
        return $data;
    }
}