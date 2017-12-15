<?php

namespace iArcadia\MagicPokeAPI\Requests;

use iArcadia\MagicPokeAPI\PokeAPI;
use iArcadia\MagicPokeAPI\Exceptions\PokeApiCUrlException;

/**
 * HTTP requests builder with cURL.
 *
 * @author Kévin Bibollet <bibollet.kevin@gmail.com>
 * @license MIT
 */
class CURL
{
    /**
     * Send a HTML request thanks to cURL.
     *
     * @throws PokeAPICUrlException if the request returns a code different than 200 (OK).
     *
     * @param PokeAPI $api The API instance which called this method.
     *
     * @return string
     */
    public static function send(PokeAPI $api)
    {
        $curl = curl_init();
        $data = null;
        $responseCode = null;
        
        curl_setopt($curl, CURLOPT_URL, $api->url);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        
        $data = curl_exec($curl);
        $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        curl_close($curl);
        
        if ($responseCode !== 200)
        {
            throw new PokeApiCUrlException($responseCode);
        }
        
        return $data;
    }
    
    /**
     * Send a HTML request thanks to cURL.
     *
     * @throws PokeAPICUrlException if the request returns a code different than 200 (OK).
     *
     * @param string $url The URL that will be used for the request.
     *
     * @return string
     */
    public static function sendByUrl(string $url)
    {
        $curl = curl_init();
        $data = null;
        $responseCode = null;
        
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        
        $data = curl_exec($curl);
        $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        curl_close($curl);
        
        if ($responseCode !== 200)
        {
            throw new PokeApiCUrlException($responseCode);
        }
        
        return $data;
    }
}