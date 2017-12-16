<?php

namespace iArcadia\MagicPokeAPI;

use iArcadia\MagicPokeAPI\Exceptions\PokeApiException;

use iArcadia\MagicPokeAPI\Requests\Request;
use iArcadia\MagicPokeAPI\Cache\Cache;

use iArcadia\MagicPokeAPI\Helpers\URLBuilder;
use iArcadia\MagicPokeAPI\Helpers\Config;
use iArcadia\MagicPokeAPI\Helpers\Constant;
use iArcadia\MagicPokeAPI\Helpers\Lang;

/**
 * Constructs URL and HTTP Requests in order to get data.
 *
 * @author Kévin Bibollet <bibollet.kevin@gmail.com>
 * @license MIT
 */
class PokeAPI
{
    /** @var bool If the next request will force the update of cache. */
    public $cacheForcing = false;
    
    protected $URLBuilder;
    
    /**
     * Constructor method.
     *
     * @param array|null $options Properties to set at instance creation.
     */
    public function __construct(array $options = null)
    {
        $this->URLBuilder = new URLBuilder;
        
        if ($options)
        {
            if (isset($options['limit'])) { $this->limit = $options['limit']; }
            if (isset($options['offset'])) { $this->offset = $options['offset']; }
            else if (isset($options['skip'])) { $this->offset = $options['skip']; }
            if (isset($options['resource'])) { $this->resource = $options['resource']; }
        }
    }
    
    /**
     * Getting properties method override.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get(string $name)
    {
        switch ($name)
        {
            case 'limit':
            case 'offset':
            case 'resource':
            case 'url':
                return $this->URLBuilder->$name;
                break;
                
            default:
                return $this->$name;
        }
    }
    
    /**
     * Setting properties method override.
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set(string $name, $value)
    {
        switch ($name)
        {
            case 'limit':
            case 'offset':
            case 'resource':
            case 'url':
                $this->URLBuilder->$name = $value;
                break;
                
            default:
                $this->$name = $value;
        }
    }
    
    /**
     * Sets or gets the number of results the API will send.
     *
     * @param int|null $limit The number of results. If null, the method returns the current value.
     *
     * @return int|PokeAPI
     */
    public function limit(int $limit = null)
    {
        if ($limit !== null) { $this->limit = $limit; }
        
        return ($limit !== null) ? $this : $this->limit ;
    }
    
    /**
     * Sets or gets the number of results the API will skip.
     *
     * @param int|null $offset The number of results. If null, the method returns the current value.
     *
     * @return int|PokeAPI
     */
    public function offset(int $offset = null)
    {
        if ($offset !== null) { $this->offset = $offset; }
        
        return ($offset !== null) ? $this : $this->offset;
    }
    
    /**
     * Alias for the "offset" method.
     *
     * @param int|null $offset The number of results. If null, the method returns the current value.
     *
     * @return int|PokeAPI
     */
    public function skip(int $skip = null)
    {
        return $this->offset($skip);
    }
    
    /**
     * Sets or gets the type of resource the API will send.
     *
     * @param string|null $resource The type of resource. If null, the method returns the current type.
     *
     * @return string|PokeAPI
     */
    public function resource(string $resource = null)
    {
        if ($resource) { $this->resource = $resource; }
        
        return ($resource) ? $this : $this->resource;
    }
    
    /**
     * Sets the forcing of the cache update for the next request.
     *
     * @return PokeAPI
     */
    public function cacheForcing(bool $force = null)
    {
        if ($force !== null) { $this->cacheForcing = $force; }
        
        return ($force !== null) ? $this : $this->cacheForcing;
    }
    
    /**
     * Gets the asked data from the API server, endpoint or specific item.
     *
     * @param string|null $search If provided, it will build an URL for a specific item.
     *
     * @return string
     */
    public function get($search = null, string $url = null)
    {
        $response = null;
        
        if (!$url)
        {
            $this->URLBuilder->build($search);
        }
        else
        { 
            $this->url = $url;
            $this->URLBuilder->buildRaw();
        }
        
        if (Config::get('cache.use'))
        {
            $response = Cache::get($this->url);
            
            if (!$response)
            {
                $response = Request::send($this->url);
                Cache::cache($this->url, $response);
            }
        }
        else
        {
            $response = Request::send($this->url);
        }
        
        $this->cacheForcing = false;;
        
        return (is_string($response)) ? json_decode($response) : $response;
    }
    
    /**
     * Gets the data of a specific item from the API server.
     *
     * @param string $search The name or the ID of the item.
     *
     * @return string
     */
    public function find($search)
    {
        if (Lang::isUsed())
        {
            $resource = $this->resource;
            $trans = Lang::search($resource, $search);
            
            if ($trans) { $search = $trans; }
        }
        
        return $this->get($search);
    }
    
    /**
     * Uses custom URL(s) for the next request.
     *
     * @return string
     */
    public function raw(...$urls)
    {
        if (empty($urls)) { return null; }
        else if (sizeof($urls) === 1) { return $this->get(null, $urls[0]); }
        else { return $this->manyRaw($urls); }
    }
    
    /**
     * Returns an array of results got with raw() method.
     *
     * @param array $urls The URLs to use.
     *
     * @return array
     */
    protected function manyRaw(array $urls)
    {
        $results = [];
        
        foreach ($urls as $url)
        {
            $results[] = $this->raw($url);
        }
        
        return $results;
    }
}