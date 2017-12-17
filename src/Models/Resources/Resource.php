<?php

namespace iArcadia\MagicPokeAPI\Models\Resources;

use iArcadia\MagicPokeAPI\PokeAPI;

class Resource
{
    /** @var string The last used type of resource. */
    public $resource;
    
    /**
     * Constructor method.
     *
     * @param string
     */
    public function __construct(string $resource = null)
    {
        if ($resource) { $this->resource = $resource; }
    }
    
    /**
     * Sets or gets the type of resource the API will send.
     *
     * @param string|null $resource
     *
     * @return string|Resource
     */
    public function resource(string $resource = null)
    {
        if ($resource) { $this->resource = $resource; }
        
        return ($resource) ? $this : $this->resource;
    }
    
    /**
     * Gets resource data.
     *
     * @param string|int $search
     *
     * @return Resource
     */
    public function find($search)
    {
        $api = new PokeAPI(['resource' => $this->resource]);
        
        $data = $api->find($search);
        
        unset($api);
        
        foreach ($data as $prop => $value)
        {
            $this->$prop = $value;
        }
        
        return $this;
    }
}