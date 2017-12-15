<?php

use iArcadia\MagicPokeAPI\PokeAPI;
use iArcadia\MagicPokeAPI\Helpers\Config;

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

if (!function_exists('magicpokeapi_get'))
{
    /**
     * Gets the endpoint data from the API server.
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