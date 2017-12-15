<?php

namespace iArcadia\MagicPokeAPI;

use iArcadia\MagicPokeAPI\Exceptions\PokeApiException;

use iArcadia\MagicPokeAPI\Helpers\URLBuilder;

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
    
    const RESOURCE_BERRY = 'berry';
    const RESOURCE_BERRY_FIRMNESS = 'berry-firmness';
    const RESOURCE_BERRY_FLAVOR = 'berry-flavor';
    const RESOURCE_CONTEST_TYPE = 'content-type';
    const RESOURCE_CONTEST_EFFECT = 'contest-effect';
    const RESOURCE_SUPER_CONTEST_EFFECT = 'super-contest-effect';
    const RESOURCE_ENCOUNTER_METHOD = 'encounter-method';
    const RESOURCE_ENCOUNTER_CONDITION = 'encounter-condition';
    const RESOURCE_ENCOUNTER_CONDITION_VALUE = 'encounter-condition-value';
    const RESOURCE_EVOLUTION_CHAIN = 'evolution-chain';
    const RESOURCE_EVOLUTION_TRIGGER = 'evolution-trigger';
    const RESOURCE_GENERATION = 'generation';
    const RESOURCE_POKEDEX = 'pokedex';
    const RESOURCE_VERSION = 'version';
    const RESOURCE_VERSION_GROUP = 'version-group';
    const RESOURCE_ITEM = 'item';
    const RESOURCE_ITEM_ATTRIBUTE = 'item-attribute';
    const RESOURCE_ITEM_CATEGORY = 'item-category';
    const RESOURCE_ITEM_FLING_EFFECT = 'item-fling-effect';
    const RESOURCE_ITEM_POCKET = 'item-pocket';
    const RESOURCE_MACHINE = 'machine';
    const RESOURCE_MOVE = 'move';
    const RESOURCE_MOVE_AILMENT = 'move-ailment';
    const RESOURCE_MOVE_BATTLE_STYLE = 'move-battle-style';
    const RESOURCE_MOVE_CATEGORY = 'move-category';
    const RESOURCE_MOVE_DAMAGE_CLASS = 'move-damage-class';
    const RESOURCE_MOVE_LEARN_METHOD = 'move-learn-method';
    const RESOURCE_MOVE_TARGET = 'move-target';
    const RESOURCE_LOCATION = 'location';
    const RESOURCE_LOCATION_AREA = 'location-area';
    const RESOURCE_PAL_PARK_AREA = 'pal-park-area';
    const RESOURCE_REGION = 'region';
    const RESOURCE_ABILITY = 'ability';
    const RESOURCE_CHARACTERISTIC = 'characteristic';
    const RESOURCE_EGG_GROUP = 'egg-group';
    const RESOURCE_GENDER = 'gender';
    const RESOURCE_GROWTH_RATE = 'growth-rate';
    const RESOURCE_NATURE = 'nature';
    const RESOURCE_POKEATHLON_STAT = 'pokeathlon-stat';
    const RESOURCE_POKEMON = 'pokemon';
    const RESOURCE_POKEMON_COLOR = 'pokemon-color';
    const RESOURCE_POKEMON_FORM = 'pokemon-form';
    const RESOURCE_POKEMON_HABITAT = 'pokemon-habitat';
    const RESOURCE_POKEMON_SHAPE = 'pokemon-shape';
    const RESOURCE_POKEMON_SPECIES = 'pokemon-species';
    const RESOURCE_STAT = 'stat';
    const RESOURCE_TYPE = 'type';
    const RESOURCE_LANGUAGE = 'language';
    
    const API_URL = 'https://pokeapi.co/api/v2/';
    
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
     * Gets the class used for caching system.
     *
     * @return string
     */
    public static function CacheSystem()
    {
        return 'iArcadia\MagicPokeAPI\Cache\\' . self::config('cache.class');
    }
    
    /**
     * Gets the class used for request system.
     *
     * @return string
     */
    public static function RequestSystem()
    {
        return 'iArcadia\MagicPokeAPI\Requests\\' . self::config('request.class');
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
        
        if (PokeAPI::config('cache.use'))
        {
            $response = PokeAPI::CacheSystem()::get($this);
            
            if (!$response)
            {
                $response = PokeAPI::RequestSystem()::send($this);
                PokeAPI::CacheSystem()::cache($this, $response);
            }
        }
        else
        {
            $response = PokeAPI::RequestSystem()::send($this);
        }
        
        $this->cacheForcing(false);
        
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
        if (PokeAPI::config('lang.use'))
        {
            $search = PokeAPI::lang($search);
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
        if (sizeof($urls) === 1) { return $this->get(null, $urls[0]); }
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
    
    /**
     * Creates the URL that will be used in the next request.
     *
     * @throws PokeApiException if no resource type has been provided.
     *
     * @param string $search This parameter is checked in order to know if it is an endpoint or a specific item.
     *
     * @return string
     */
    protected function createUrl($search = null)
    {
        if (!$this->resource)
        {
            throw new PokeApiException('A PokeAPI resource is needed in order to access the API.', 500);
        }
        
        if (!$search)
        {
            $params = ["limit={$this->limit}", "offset={$this->offset}"];

            $this->url = PokeAPI::API_URL . $this->resource . '/?' . join('&', $params);
        }
        else
        {
            $this->url = PokeAPI::API_URL . $this->resource . '/' . $search . '/';
        }
        
        return $this->url;
    }
    
    /**
     * Gets values from a configuration file.
     *
     * @param string $config Where to search.
     *
     * @return mixed
     */
    public static function config(string $config)
    {
        $path = explode('.', $config);
        $file = $path[0];
        $key = (isset($path[1]))
            ? $path[1]
            : null;
        $result = null;
        
        if (file_exists(__DIR__ . "/config/{$file}.php"))
        {
            $result = require __DIR__ . "/config/{$file}.php";
            
            if ($key) { $result = $result[$key]; }
        }
        else
        {
            throw new PokeApiFileException('Impossible to get the wanted configuration because ' . __DIR__ . "/config/{$file}.php does not exist.", 500);
        }
        
        return $result;
    }
    
    /**
     * Gets values from a language file.
     *
     * @param string $search Where to search.
     *
     * @return mixed
     */
    public static function lang(string $search)
    {
        /*$path = explode('.', $config);
        $file = $path[0];
        $key = (isset($path[1]))
            ? $path[1]
            : null;*/
        $file = PokeAPI::config('lang.lang');
        $result = null;
        
        if (file_exists(__DIR__ . "/lang/{$file}.php"))
        {
            $result = require __DIR__ . "/lang/{$file}.php";
            
            if (isset($result[$search])) { $result = $result[$search]; }
            else { $result = $search; }
        }
        else
        {
            throw new PokeApiFileException('Impossible to get the wanted translation because ' . __DIR__ . "/lang/{$file}.php does not exist.", 500);
        }
        
        return $result;
    }
}