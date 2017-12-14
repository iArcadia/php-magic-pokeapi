## MagicPokeAPI for PHP
[![Packagist License](https://poser.pugx.org/iarcadia/php-magic-pokeapi/license.png)](http://choosealicense.com/licenses/mit/)
[![Latest Stable Version](https://poser.pugx.org/iarcadia/php-magic-pokeapi/version.png)](https://packagist.org/packages/iarcadia/php-magic-pokeapi)
[![Total Downloads](https://poser.pugx.org/iarcadia/php-magic-pokeapi/d/total.png)](https://packagist.org/packages/iarcadia/php-magic-pokeapi)

This package is a POO-oriented PHP wrapper for using the RESTful API [PokéAPI](https://pokeapi.co/). With MagicPokeAPI, you can obtain tons of data from PokéAPI server, thanks to some lines. The package include an useful mini caching system.

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

Please, respect the comments written in these files.

## Usage

### First step

Yep, you probably guess right: you have to create an instance of your favorite PokéAPI wrapper in order to continue.

```
$api = new PokeAPI();
```

Don't forget to ```include``` files or to ```use``` classes. (e.g. ```use iArcadia\MagicPokeAPI\PokeAPI```)

### Second step

You must specify the resource that you want to look for! Use the ```resource()``` method.

```
$api->resource('pokemon');
// or (and the recommended one)
$api->resource(PokeAPI::RESOURCE_POKEMON);
```

The ```PokeAPI``` class provides a constant for all resources. It could be a good idea to use them instead of direct string.

### Endpoints

#### Setting the number of results (or "limit")

Use the ```limit()``` method.

```
$api->limit(20);
```

#### Setting the search starting point (or "offset")

Use the ```offset()``` or the ```skip()``` method.

```
$api->offset(5);
// or
$api->skip(5);
```

The ```skip()``` method is an alias for the ```offset()``` one.

#### Executing the request

Use the ```get()``` method.

```
$data = $api->get();
```

### Resource details

Very simple, just use the ```find()``` method.

```
// by name
$item = $api->find('arcanine');
// or by id
$item = $api->find(25);
```

## Tips

### Chaining methods

Thanks to the power of the POO, you can quickly set up options between two different requests.

```
// for endpoint
$api->limit(20)->offset(60)->resource(PokeAPI::RESOURCE_ITEM')->get();
// for resource details
$api->resource(PokeAPI::RESOURCE_ITEM)->find('potion');
```

### Constructor options

If you prefer, you can also set up options at the instance creation (if you know that they won't change for example).

```
$api = new PokeApi(
[
    'limit' => 20,
    'offset' => 0, // works with "skip" too
    'resource' => PokeAPI::RESOURCE_CONTEST_EFFECT
]);
```