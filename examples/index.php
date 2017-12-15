<?php

/*
 * Autoloading of all MagicPokeAPI files.
 */
require_once('vendor/autoload.php');

require_once('../src/PokeAPI.php');

require_once('../src/Helpers/URLBuilder.php');

require_once('../src/Requests/CURL.php');
require_once('../src/Requests/File.php');

require_once('../src/Cache/FileCache.php');

require_once('../src/Exceptions/PokeApiException.php');
require_once('../src/Exceptions/PokeApiCUrlException.php');
require_once('../src/Exceptions/PokeApiFileException.php');
/* End autoloading */

use iArcadia\MagicPokeAPI\PokeAPI;

/*
 * We create a new instance of the PokeAPI wrapper.
 */
$api = new PokeAPI();

/* Gets from PokeAPI server, data of the pokemon named "Arcanine". */
$arcanine = $api->resource(PokeAPI::RESOURCE_POKEMON)->find('arcanine');
//var_dump($arcanine);

/* Gets from PokeAPI server, data of 5 abilities, starting from the 10th. */
$abilities = $api->resource(PokeAPI::RESOURCE_ABILITY)->limit(5)->offset(10)->get();
//var_dump($abilities);

/* Gets from PokeAPI server, data of 22 berries, starting from the 3rd. */
$api->resource(PokeAPI::RESOURCE_BERRY);
$api->skip(3);
$api->limit(22);
$berries = $api->get();
//var_dump($berries);

/* Gets from PokeAPI server, data of the region of ID 4. */
$api->cacheForcing(true);
$api->resource(PokeAPI::RESOURCE_REGION);
$region = $api->find(4);
//var_dump($region);

//var_dump($api);