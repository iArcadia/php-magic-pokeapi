<?php

/*
 * Autoloading of all MagicPokeAPI files.
 */
require_once('Autoload.php');

foreach (Autoload::load('../src/') as $file)
{
    require_once($file);
}
/* End autoloading */

use iArcadia\MagicPokeAPI\API;

/*
 * We create a new instance of the PokeAPI wrapper.
 */
$api = new API();

/* Gets from PokeAPI server, data of the pokemon named "Arcanine". */
$arcanine = $api->resource(API::RESOURCE_POKEMON)->find('arcanine');
//var_dump($arcanine);

/* Gets from PokeAPI server, data of 5 abilities, starting from the 10th. */
$abilities = $api->resource(API::RESOURCE_ABILITY)->limit(5)->offset(10)->get();
//var_dump($abilities);

/* Gets from PokeAPI server, data of 22 berries, starting from the 3rd. */
$api->resource(API::RESOURCE_BERRY);
$api->offset(3);
$api->limit(22);
$berries = $api->get();
//var_dump($berries);

/* Gets from PokeAPI server, data of the region of ID 4. */
$api->resource(API::RESOURCE_REGION);
$region = $api->find(4);
//var_dump($region);

/* Sets off caching system. (Please, don't.) */
$api->setCaching(false);

/* Sets alive time of cached files to one month. */
$api->cacheExpiration(60 * 60 * 24* 30);

//var_dump($api);