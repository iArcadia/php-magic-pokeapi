<?php

namespace iArcadia\MagicPokeAPI\Requests;

use iArcadia\MagicPokeAPI\PokeAPI;

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
     * @param PokeAPI $api The API instance which called this method.
     *
     * @return string
     */
    public static function send(PokeAPI $api)
    {
        $curl = curl_init();
        $data = null;
        $responseCode = null;
        
        curl_setopt($curl, CURLOPT_URL, $api->url());
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, PokeAPI::config('request.timeout'));
        
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