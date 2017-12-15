## MagicPokeAPI for PHP
[![Packagist License](https://poser.pugx.org/iarcadia/php-magic-pokeapi/license.png)](http://choosealicense.com/licenses/mit/)
[![Latest Stable Version](https://poser.pugx.org/iarcadia/php-magic-pokeapi/version.png)](https://packagist.org/packages/iarcadia/php-magic-pokeapi)
[![Total Downloads](https://poser.pugx.org/iarcadia/php-magic-pokeapi/d/total.png)](https://packagist.org/packages/iarcadia/php-magic-pokeapi)

This package is a POO-oriented PHP wrapper for using the RESTful API [PokéAPI](https://pokeapi.co/). With MagicPokeAPI, you can obtain tons of data from PokéAPI server, thanks to some lines. The package includes an useful mini caching system.

## What's PokéAPI?

This is a full RESTful API linked to an extensive database detailing everything about the Pokémon main game series.

## Installation

Require this package with composer:

```
composer require iarcadia/php-magic-pokeapi
```

## Configuration

First of all, you need to check files into the ```config``` folder.

```cache.php``` is cache systems related.

```request.php``` is request systems related.

```lang.php``` is language systems related.

Please, respect the comments written in these files.

## Usage

### First step

Yep, you probably guess right: you have to create an instance of your favorite PokéAPI wrapper in order to continue.

```php
$api = new PokeAPI();
```

Don't forget to ```include``` files or to ```use``` classes. (e.g. ```use iArcadia\MagicPokeAPI\PokeAPI```)

### Second step

You must specify the resource that you want to look for! Use the ```resource()``` method.

```php
$api->resource('pokemon');
// or (and the recommended one)
$api->resource(PokeAPI::RESOURCE_POKEMON);
```

The ```PokeAPI``` class provides constants for all resources. It could be a good idea to use them instead of direct string.

A constant list is available in ```src/PokeAPI.php``` file.

### Endpoints

#### Setting the number of results (or "limit")

Use the ```limit()``` method.

```php
$api->limit(20);
```

#### Setting the search starting point (or "offset")

Use the ```offset()``` or the ```skip()``` method.

```php
$api->offset(5);
// or
$api->skip(5);
```

The ```skip()``` method is an alias for the ```offset()``` one.

#### Executing the request

Use the ```get()``` method.

```php
$data = $api->get();
```

### Resource details

Very simple, just use the ```find()``` method.

```php
// by name
$item = $api->find('arcanine');
// or by id
$item = $api->find(25);
```

### Other

### Requesting raw URLs

You want to directly write your URL? Use the ```raw()``` method.

```php
// endpoint
$api->raw('/ability/');
// with parameters
$api->raw('/pokemon-species/?limit=30&offset=60');
// resource details
$api->raw('/pokemon/bulbasaur/');
// with full URL
$api->raw('https://www.pokeapi.co/api/v2/item/203');
```

Note that after using it, your ```PokeAPI``` object properties (url, resource, limit and offset) will be updated from your raw URL.

### Forcing the cache update

If a reason, you want to force the update of a cached file, use the ```cacheForcing()``` method.

```php
$api->cacheForcing(true);
```

It will update the cache for the next request ONLY.

## Tips

### Chaining methods

Thanks to the power of the POO, you can quickly set up options between two different requests.

```php
// for endpoint
$api->limit(20)->offset(60)->resource(PokeAPI::RESOURCE_ITEM)->get();
// for resource details
$api->resource(PokeAPI::RESOURCE_ITEM)->find('potion');
```

### Constructor options

If you prefer, you can also set up options at the instance creation (if you know that they won't change for example).

```php
$api = new PokeApi(
[
    'limit' => 20,
    'offset' => 0, // works with "skip" too
    'resource' => PokeAPI::RESOURCE_CONTEST_EFFECT
]);
```

### Using automatic resource name translation

/!\ CURRENTLY ONLY WORK WITH POKEMON NAME /!\

If you decide to activate the automatic resource name translation (in the ```config/lang.php``` file), you will be able to use your language name for requesting data!

```php
// Charizard in french will be translated to:
// $api->resource(PokeAPI::RESOURCE_POKEMON)->find('charizard');
$api->resource(PokeAPI::RESOURCE_POKEMON)->find('dracaufeu');

// Nidoqueen in korean will be translated to:
// $api->resource(PokeAPI::RESOURCE_POKEMON)->find('nidoqueen');
$api->resource(PokeAPI::RESOURCE_POKEMON)->find('니드퀸');
```

Bonus: even if you use this feature, all english will continue to work!

## CHANGELOGS

See [CHANGELOGS.md](https://github.com/iArcadia/php-magic-pokeapi/blob/master/CHANGELOGS.md)