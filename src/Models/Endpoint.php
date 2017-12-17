<?php

namespace iArcadia\MagicPokeAPI\Models;

use iArcadia\MagicPokeAPI\PokeAPI;

class Endpoint
{
    /** @var int The number of result the API will send. */
    public $limit = 20;
    /** @var int The number of result the API will skip. */
    public $offset = 0;
    /** @var string The last used type of resource. */
    public $resource;
    
    public $count;
    public $previous;
    public $results;
    public $next;
    
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
        }
    }
    
    /**
     * Sets or gets the number of results the API will send.
     *
     * @param int|null $limit The number of results. If null, the method returns the current value.
     *
     * @return int|Endpoint
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
     * @return int|Endpoint
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
     * @return int|Endpoint
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
     * @return string|Endpoint
     */
    public function resource(string $resource = null)
    {
        if ($resource) { $this->resource = $resource; }
        
        return ($resource) ? $this : $this->resource;
    }
    
    /**
     * Gets endpoint data.
     *
     * @return Endpoint
     */
    public function get(): Endpoint
    {
        $api = new PokeAPI(
        [
            'limit' => $this->limit,
            'offset' => $this->offset,
            'resource' => $this->resource
        ]);
        
        $data = $api->get();
        
        unset($api);
        
        $this->count = $data->count;
        $this->results = $data->results;
        $this->previous = $data->previous;
        $this->next = $data->next;
        
        return $this;
    }
    
    /**
     * Gets the next endpoint.
     *
     * @throws Exception if there is no next endpoint.
     *
     * @return Endpoint
     */
    public function getNext(): Endpoint
    {
        if (!$this->next)
        {
            throw new \Exception('No next endpoint found');
        }
        
        $this->offset += $this->limit;
        
        return $this->get();
    }
    
    /**
     * Gets the previous endpoint.
     *
     * @throws Exception if there is no previous endpoint.
     *
     * @return Endpoint
     */
    public function getPrevious(): Endpoint
    {
        if (!$this->previous)
        {
            throw new \Exception('No previous endpoint found');
        }
        
        $this->offset -= $this->limit;
        
        return $this->get();
    }
}