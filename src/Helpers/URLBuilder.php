<?php

namespace iArcadia\MagicPokeAPI\Helpers;

use iArcadia\MagicPokeAPI\PokeAPI;

use iArcadia\MagicPokeAPI\Errors\ErrorMessage;
use TypeError;

/**
 * Builds API URLs.
 *
 * @author Kévin Bibollet <bibollet.kevin@gmail.com>
 * @license MIT
 */
class URLBuilder
{
    
    /** @var int The number of result the API will send. */
    public $limit = 20;
    /** @var int The number of result the API will skip. */
    public $offset = 0;
    /** @var string The last used type of resource. */
    public $resource;
    /** @var string The URL used by the last request. */
    public $url;
    
    const API_URL = 'https://www.pokeapi.co/api/v2/';
    
    /**
     * Builds the URL for requests.
     *
     * @return string
     */
    public function build($search = null): string
    {
        $this->url = ($search)
            ? $this->buildResource($search)
            : $this->buildEndpoint();
        
        return $this->url;
    }
    
    /**
     * Builds the URL for endpoint requests.
     *
     * @return string
     */
    public function buildEndpoint(): string
    {
        $base = trim(self::API_URL, '/');
        $params = "?limit={$this->limit}&offset={$this->offset}";
        
        $this->url = join('/', [$base, $this->resource, $params]);
        
        return $this->url;
    }
    
    /**
     * Builds the URL for resource requests.
     *
     * @throws TypeError if the $search argument is not of the expected type.
     *
     * @param string|int $search
     *
     * @return string
     */
    public function buildResource($search): string
    {
        if (!is_string($search) && !is_int($search)) { throw new TypeError(ErrorMessage::TypeError(1, 'string or int')); }
        
        $base = trim(self::API_URL, '/');
        
        $this->url = join('/', [$base, $this->resource, $search]);
        
        return $this->url;
    }
    
    /**
     * Builds the URL for raw requests.
     *
     * @return string
     */
    public function buildRaw(): string
    {
        if (!URLBuilder::isComplete($this->url))
        {
            $this->url = join('/', [trim(self::API_URL, '/'), trim($this->url, '/')]);
        }
        
        $this->url = trim($this->url, '/');
        
        return $this->url;
    }
    
    /**
     * Checks if the passed URL is complete (starting with "https://www.pokeapi.co/api/v2/") or not.
     *
     * @param string $url
     *
     * @return bool
     */
    public static function isComplete(string $url): bool
    {
        $apiURL = str_replace(['/', '.'], ['\/', '\.'], self::API_URL);
        
        return preg_match("/^{$apiURL}/", $url);
    }
    
    /**
     * Checks if the passed URL matches for an endpoint request. Returns false is the URL is not a complete one.
     *
     * @param string $url
     *
     * @return bool
     */
    public static function isEndpoint(string $url): bool
    {
        return self::isComplete($url) && preg_match('/v2\/?[a-z-]+\/?(?:\?[a-z0-9=&-]+\/?)?$/', $url);
    }
    
    /**
     * Checks if the passed URL matches for a resource request. Returns false is the URL is not a complete one.
     *
     * @param string $url
     *
     * @return bool
     */
    public static function isResource(string $url): bool
    {
        return self::isComplete($url) && preg_match('/\/?[a-z-]+\/[a-z0-9-]+\/?$/', $url);
    }
    
    /*public static function extractFromURL(string $url): array
    {
        $data = [];
        
        if (URLBuilder::isEndpoint($url))
        {
            
        }
        else if (URLBuilder::isResource($url))
        {
            
        }
        
        return $data;
    }*/
}