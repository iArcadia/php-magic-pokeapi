<?php

namespace iArcadia\MagicPokeAPI\Models\Resources;

use iArcadia\MagicPokeAPI\Models\Resources\Resource;
use iArcadia\MagicPokeAPI\PokeAPI;
use iArcadia\MagicPokeAPI\Helpers\Constant;

class Pokemon extends Resource
{
    /**
     * Constructor method.
     *
     * @param string|int
     */
    public function __construct(string $search)
    {
        $this->resource = Constant::RESOURCE_POKEMON;
        
        $this->find($search);
        
        unset($this->resource);
        
        return $this;
    }
}