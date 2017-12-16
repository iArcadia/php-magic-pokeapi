## MagicPokeAPI for PHP
[![Packagist License](https://poser.pugx.org/iarcadia/php-magic-pokeapi/license.png)](http://choosealicense.com/licenses/mit/)
[![Latest Stable Version](https://poser.pugx.org/iarcadia/php-magic-pokeapi/version.png)](https://packagist.org/packages/iarcadia/php-magic-pokeapi)
[![Total Downloads](https://poser.pugx.org/iarcadia/php-magic-pokeapi/d/total.png)](https://packagist.org/packages/iarcadia/php-magic-pokeapi)

This package is a POO-oriented PHP wrapper for using the **version 2** of the RESTful API [PokéAPI](https://pokeapi.co/). With MagicPokeAPI, you can obtain tons of data from PokéAPI server, thanks to some lines. The package includes an useful mini caching system.

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

## Usage overview

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
$api->resource(Constant::RESOURCE_POKEMON);
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
You can specify many URLs with many arguments.

```php
$api->raw('/ability/', 'https://www.pokeapi.co/api/v2/item/203');
```

## Tips

### Chaining methods

Thanks to the power of the POO, you can quickly set up options between two different requests.

```php
// for endpoint
$api->limit(20)->offset(60)->resource(PokeAPI::RESOURCE_ITEM)->get();
// for resource details
$api->resource(Constant::RESOURCE_ITEM)->find('potion');
```

### Constructor options

If you prefer, you can also set up options at the instance creation (if you know that they won't change for example).

```php
$api = new PokeApi(
[
    'limit' => 20,
    'offset' => 0, // works with "skip" too
    'resource' => Constant::RESOURCE_CONTEST_EFFECT
]);
```

### Using automatic resource name translation

/!\ CURRENTLY ONLY WORK WITH POKEMON NAME /!\

If you decide to activate the automatic resource name translation (in the ```config/lang.php``` file), you will be able to use your language name for requesting data!

```php
// Charizard in french will be translated to:
// $api->resource(Constant::RESOURCE_POKEMON)->find('charizard');
$api->resource(Constant::RESOURCE_POKEMON)->find('dracaufeu');

// Nidoqueen in korean will be translated to:
// $api->resource(Constant::RESOURCE_POKEMON)->find('nidoqueen');
$api->resource(Constant::RESOURCE_POKEMON)->find('니드퀸');

### Procedural functions

Maybe you don't like POO? No problem, a helper file exists and wraps for you most of MagicPokeAPI classes!

```php
// getting pokemon endpoint from 30 to 35:
magicpokeapi_get('pokemon', 5, 30);
// getting Johto region resource:
magicpokeapi_find('region', 'johto');
```

## CHANGELOGS

See [CHANGELOGS.md](https://github.com/iArcadia/php-magic-pokeapi/blob/master/CHANGELOGS.md)