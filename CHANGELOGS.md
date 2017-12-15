## CHANGELOGS

### v1.1.0 | 2017-12-15

#### PokeAPI

- Add recache forcing
```php
// Forcing to recache the next request:
$api->cacheForcing(true);
```

- Add requests using direct URLs
```php
// Getting item endpoint with a limit and an offset:
$api->raw('https://www.pokeapi.co/api/v2/item/?limit=5&offset=120');
```

- Add automatic resource name translation (only for pokemon)
```php
// Getting charizard information using its french name:
$api->resource(PokeAPI::RESOURCE_POKEMON)->find('dracaufeu');
```

#### FileCache

- Add cache clearing
```php
// Clearing the cache directory:
FileCache::clear();
```

### v1.0.0 | 2017-12-13

Initial commit