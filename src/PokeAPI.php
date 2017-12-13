<?php

namespace iArcadia\MagicPokeAPI;

use iArcadia\MagicPokeAPI\Exceptions\PokeApiException;

/**
 * Constructs URL and HTTP Requests in order to get data.
 *
 * @author Kévin Bibollet <bibollet.kevin@gmail.com>
 * @license MIT
 */
class PokeAPI
{
    /** @var int The number of result the API will send. */
    protected $limit = 20;
    /** @var int The number of result the API will skip. */
    protected $offset = 0;
    /** @var string The type of resource. */
    protected $resource;
    /** @var string The URL used by the last request. */
    protected $url;
    
    /** @var boolean If the caching system is used or not. */
    protected $useCaching = true;
    /** @var string The caching type the API will use. */
    protected $cachingType = self::CACHE_TYPE_FILE;
    /** @var int The time during cached files will exist before being overwritten. */
    protected $cacheExpiration = 3600;
    
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
    
    const CACHE_TYPE_FILE = 'FileCache';
    
    const API_URL = 'https://pokeapi.co/api/v2/';
    
    /**
     * Constructor method.
     *
     * @param array|null $options Properties to set at instance creation.
     */
    public function __construct(array $options = null)
    {
        if ($options)
        {
            if (isset($options['limit'])) { $this->limit = $options['limit']; }
            if (isset($options['offset'])) { $this->offset = $options['offset']; }
            else if (isset($options['skip'])) { $this->offset = $options['skip']; }
            if (isset($options['resource'])) { $this->resource = $options['resource']; }
            if (isset($options['useCaching'])) { $this->useCaching = $options['useCaching']; }
            if (isset($options['cacheExpiration'])) { $this->cacheExpiration = $options['cacheExpiration']; }
            if (isset($options['cachingType'])) { $this->cachingType = $options['cachingType']; }
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
        if ($limit) { $this->limit = $limit; }
        
        return ($limit) ? $this : $this->limit ;
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
        if ($offset) { $this->offset = $offset; }
        
        return ($offset) ? $this : $this->offset;
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
     * Gets the URL used by the last request.
     *
     * @return string|null
     */
    public function url()
    {
        return $this->url;
    }
    
    /**
     * Returns if the caching system will be used.
     *
     * @return boolean
     */
    public function useCaching()
    {
        return $this->useCaching;
    }
    
    /**
     * Sets if the caching system will be used.
     *
     * @param boolean $caching Use the caching system or not.
     *
     * @return PokeAPI
     */
    public function setCaching(bool $caching)
    {
        $this->useCaching = $caching;
        
        return $this;
    }
    
    /**
     * Sets or gets the amount of time in seconds a cache item can exist.
     *
     * @param int|null $expire The amount of time. If null, the method returns the current time.
     *
     * @return int|PokeAPI
     */
    public function cacheExpiration(int $expire = null)
    {
        if ($expire) { $this->cacheExpiration = $expire; }
        
        return ($expire) ? $this : $this->cacheExpiration;
    }
    
    /**
     * Gets the class name from the "cachingType" property.
     *
     * @return string
     */
    protected function getCacheClass()
    {
        return 'iArcadia\MagicPokeAPI\Cache\\' . $this->cachingType;
    }
    
    /**
     * Gets the asked data from the API server, endpoint or specific item.
     *
     * @param string|null $search If provided, it will build an URL for a specific item.
     *
     * @return string
     */
    public function get($search = null)
    {
        $response = null;
        
        $this->createUrl($search);
        
        if ($this->useCaching)
        {
            $response = $this->getCacheClass()::get($this);
            
            if (!$response)
            {
                $response = $this->sendRequest();
                $this->getCacheClass()::cache($this, $response);
            }
        }
        else
        {
            $response = $this->sendRequest();
        }
        
        return json_decode($response);
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
        return $this->get($search);
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
            throw new PokeApiException('A PokeAPI resource is needed in order to access the API.');
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
     * Send a HTML request thanks to cURL.
     *
     * @return string
     */
    protected function sendRequest()
    {
        $curl = curl_init();
        $data = null;
        $responseCode = null;
        
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        
        $data = curl_exec($curl);
        $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        curl_close($curl);
        
        if ($responseCode !== 200)
        {
            return json_encode('Oops! An error has occured...');
        }
        
        return $data;
    }
}